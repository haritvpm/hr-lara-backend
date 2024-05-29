<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use DateTime;
use Carbon\Carbon;
use App\Models\Leaf;
use App\Models\User;
use App\Models\Punching;
use Carbon\CarbonPeriod;
use App\Models\GovtCalendar;
use Illuminate\Http\Request;
use App\Models\CompenGranted;
use App\Models\EmployeeToSection;
use App\Http\Controllers\Controller;
use App\Services\LeaveProcessService;
use App\Services\PunchingCalcService;
use App\Http\Requests\StoreLeafRequest;
use App\Http\Requests\UpdateLeafRequest;
use App\Http\Resources\Admin\LeafResource;
use App\Models\LeaveGroup;
use Symfony\Component\HttpFoundation\Response;


class LeaveApiController extends Controller
{
    private function LeafToResource($leaf)
    {
        $compensGranted = CompenGranted::where('leave_id', $leaf->id)->get();
        $inLieofDates = [];
        $inLieofMonth = null;
        if ($leaf->leave_type == 'compen') {
            $inLieofDates = $compensGranted->map(function ($item) {
                return $item->date_of_work;
            });
        } else  if ($leaf->leave_type == 'compen_for_extra') {
            $inLieofMonth = $compensGranted->first()->date_of_work;
        }


        return [
            'id' => $leaf->id,
            'aadhaarid' => $leaf->aadhaarid,
            'leave_cat' => $leaf->leave_cat,
            'leave_type' => $leaf->leave_type,
            'start_date' => $leaf->start_date,
            'end_date' => $leaf->end_date,
            'time_period' => $leaf->time_period,
            'reason' => $leaf->reason,
            'leave_count' => $leaf->leave_count,
            'active_status' => $leaf->active_status,
            'proceeded' => $leaf->proceeded,
            'creation_date' => Carbon::parse($leaf->created_at)->format('Y-m-d'),
            'fromType' => $leaf->leave_cat == 'H' ? $leaf->time_period : 'full',
            'multipleDays' => $leaf->start_date != $leaf->end_date,
            'inLieofDates' => $inLieofDates,
            'inLieofMonth' => $inLieofMonth,
            'employee' => $leaf->employee,
            'owner_seat' =>  $leaf->owner,
            'owner_can_approve' => $leaf->owner_can_approve,
            //  'approver_employee_id',
            'approver_details' => $leaf->approver_details,
            'approved_on' => Carbon::parse($leaf->approved_on)->format('Y-m-d'),
            'prefix' => $leaf->prefix,
            'suffix' => $leaf->suffix,
            'date_of_joining' => $leaf->date_of_joining,

        ];
    }

    private function resourceToModel($request, $me, $owner, $owner_can_approve)
    {
        return [
            'is_aebas_leave' => false,
            'aadhaarid' => $me->employee->aadhaarid,
            'employee_id' => $me->employee_id,
            'leave_type' => $request->leave_type,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date'  => $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : Carbon::parse($request->start_date)->format('Y-m-d'),
            'reason' => $request->reason,
            'active_status' => 'N',
            'last_updated' => null,
            'creation_date' => now(),
            'created_by_aadhaarid' => $me->employee->aadhaarid,
            'processed' => false,
            'owner_seat' =>  $owner,
            'owner_can_approve' => $owner_can_approve,
            'remarks' => null,
            // 'start_date_type' => $request->fromType,
            // 'end_date_type'=> $request->toType,
            'leave_count' => $request->leave_count,
            'leave_cat' => ($request->fromType == 'an' ||  $request->fromType == 'fn') ? 'H' : 'F', //dummy required value
            'time_period' => $request->fromType == 'an' ? 'AN' : ($request->fromType == 'fn' ? 'FN' : null), //dummy required value

        ];
    }

    public function index()
    {
        // abort_if(Gate::denies('leaf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //find all leaves where owner_seat is the logged in user's seat
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if ($status == 'error') {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User has no seats mapped'
                ],
                400
            );
        }

        $leaves = Leaf::with(['employee', 'compensGranted', 'employee.designation'])
            ->wherein('owner_seat', $seat_ids_of_loggedinuser)
            ->orwherein('forwarded_by_seat', $seat_ids_of_loggedinuser)
            ->orderBy('created_at', 'desc')
            ->get()->transform(function ($leaf) use ($seat_ids_of_loggedinuser) {
                return [
                    ...$this->LeafToResource($leaf),
                    'is_owner' => $seat_ids_of_loggedinuser->contains($leaf->owner_seat),
                ];
            });


        return response()->json(
            [
                'status' => 'success',
                'leaves' => LeafResource::collection($leaves)

            ],
            200
        );
    }

    private function leaveStoreOrUpdate(Request $request, $isUpdate)
    {
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        $leave_goup_name = $me->employee->leave_group?->groupname ?? 'default';
        $leave_goup_name = strtolower($leave_goup_name);
        $leaeGroup = LeaveGroup::where('groupname', $leave_goup_name)->first();


        $c_startDate = Carbon::parse($request->start_date);
        $c_endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::parse($request->start_date);
        $aadhaarid = $me->employee->aadhaarid;

        $alreadyApplied =  LeaveProcessService::leaveAlreadyExistsForPeriod($request->start_date, $request->end_date, $aadhaarid);

        if ($alreadyApplied) {
            return response()->json(
                ['status' => 'error',  'message' => "Leave already applied for this date. (#{$alreadyApplied->id})"],
                400
            );
        }

        //check casual leave max check
        if ($request->leave_type == 'casual') {
            //note, frontend prevents leave date after this year end
            \Log::info('before getEmployeeCasualLeaves');
            \Log::info($leaeGroup->allowed_casual_per_year);
            $cl_submitted = Leaf::getEmployeeCasualLeaves($aadhaarid, $request->start_date);
            \Log::info($cl_submitted);
            $tot = (float)$request->leave_count + (float)$cl_submitted;
            //if($request->leave_count + $cl_submitted >  $leaeGroup->allowed_casual_per_year )
            {
                return response()->json(
                    ['status' => 'error',  'message' => "Casual leave count cannot be more than {$leaeGroup->allowed_casual_per_year} per year"],
                    400
                );
            }
        } //
        if ($request->leave_type == 'compen' || $request->leave_type == 'compen_for_extra') {
            //note, frontend prevents leave date after this year end
            $compen_submitted = Leaf::getEmployeeCompenLeaves($aadhaarid, $request->start_date);
            if($request->leave_count + $compen_submitted > $leaeGroup->allowed_compen_per_year ){
                return response()->json(
                    ['status' => 'error',  'message' => "Compen count cannot be more than {$leaeGroup->allowed_compen_per_year} for a year"],
                    400
                );
            }
        }


        //ok to proceed.
        \Log::info($request->all());

        //find the owner seat which is the reporting officer of this employee's section
        $sectionMapping = EmployeeToSection::with('section')->OnDate(now()->format('Y-m-d'))->where('employee_id', $me->employee_id)->first();
        if (!$sectionMapping) {
            return response()->json(
                ['status' => 'error', 'message' => 'Employee is not mapped to any section'],
                400
            );
        }
        $isCasualOrCompen = in_array($request->leave_type, ['casual', 'compen', 'compen_for_extra']);

        //casual and earned should not be adjacent
        //get prev and after dates which are not holidays and check
        [$leftWorking, $rightWorking] = GovtCalendar::getAdjacentWorkingDates($c_startDate->format('Y-m-d') , $c_endDate->format('Y-m-d'));

        //if this is casual or compen, then make sure no continuous 15 leaves are there
        if ($isCasualOrCompen) {
            [$left,$right] = Leaf::CheckContinuousCasualLeaves($aadhaarid, $request->start_date, $request->end_date);
            if( $left+$right + $request->leave_count > $leaeGroup->allowed_continuous_casual_and_compen ){
                return response()->json(
                    ['status' => 'error',  'message' => "Cannot have more than {$leaeGroup->allowed_continuous_casual_and_compen} continuous casual/compen leaves"],
                    400
                );
            }

            //make sure no adjacent earned and halfpay
           $hasNotAllowedLeaves = Leaf::verifyDatesAndLeaveTypes( $aadhaarid,  [$leftWorking, $rightWorking],
                        ['casual', 'compen', 'compen_for_extra'], null); //thes are the allowed leaves
            if( $hasNotAllowedLeaves){
                return response()->json(
                    ['status' => 'error',  'message' => "Cannot have casual/compen leaves adjacent to EL/HP..."],
                    400
                );
            }

        } else {
            //make sure no adjacent casual and compen
            $hasNotAllowedLeaves = Leaf::verifyDatesAndLeaveTypes( $aadhaarid,  [$leftWorking, $rightWorking],
                        null, ['casual', 'compen', 'compen_for_extra']); //thes are the allowed leaves
            if( $hasNotAllowedLeaves){
                return response()->json(
                    ['status' => 'error',  'message' => "Cannot have EL/HP... leaves adjacent to CL/Co"],
                    400
                );
            }
        }


        $leaf = $isUpdate ? Leaf::findOrFail($request->id) : null;

        \DB::transaction(function () use (&$leaf, $request, $me, $seat_ids_of_loggedinuser,  $sectionMapping, $isCasualOrCompen) {

            //when SO, who is the reporting officer submits, has to submit to controller
            $owner = $sectionMapping->section->seat_of_reporting_officer_id;
            $owner_can_approve = !$isCasualOrCompen; //SO can approve earned, commuted, etc
            if ($isCasualOrCompen && $seat_ids_of_loggedinuser->contains($owner) == true) {
                $owner = $sectionMapping->section->seat_of_controlling_officer_id;
                $owner_can_approve = true;
            }
            //TODO.if compen, check if this date is not already taken where is_for_extra_hours = false

            if( !$leaf ) {
                $leaf = Leaf::create(
                    $this->resourceToModel($request, $me, $owner, $owner_can_approve)
                );
            }
            else {
                $leaf->update(
                    $this->resourceToModel($request, $me, $owner, $owner_can_approve)
                );
            }

            //delete old compen_granted if it exists
            $compensGrantedOld = CompenGranted::where('leave_id', $leaf->id)->delete();

            if ($request->leave_type == 'compen' || $request->leave_type == 'compen_for_extra') {
                $this->createCompenGranteds($request, $leaf, $me);
            } //compen or compen_for_extra

            LeaveProcessService::processNewLeave($leaf);
        });

        return (new LeafResource($leaf))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function store(Request $request)
    {
        return $this->leaveStoreOrUpdate($request, false);

    }

    public function show(Leaf $leaf)
    {
        //abort_if(Gate::denies('leaf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //check if this leave is for the logged in user
        $me = User::with('employee')->find(auth()->id());

        if ($leaf->aadhaarid != $me->employee->aadhaarid || $leaf->owner_seat != null) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Leave does not belong to logged in user'
                ],
                400
            );
        }
        $leaf->load(['employee']);

        //return new LeafResource($this->LeafToResource($leaf));
        return (new LeafResource($this->LeafToResource($leaf)))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    private function createCompenGranteds($request, Leaf $leaf, $me)
    {
        \Log::info('createCompenGranteds');

        if ($leaf->leave_type == 'compen' || $leaf->leave_type == 'compen_for_extra') {

            if ($leaf->leave_type == 'compen') {
                $inLieofDates = Collect($request->inLieofDates)->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d');
                });

                foreach ($inLieofDates as $date) {
                    \Log::info('createCompenGranteds' . $date);

                    $compensGranted = new CompenGranted();
                    $compensGranted->aadhaarid = $me->employee->aadhaarid;
                    $compensGranted->leave_id = $leaf->id;
                    $compensGranted->date_of_work = $date;
                    $compensGranted->is_for_extra_hours = false;
                    $compensGranted->employee_id = $me->employee_id;
                    $compensGranted->save();
                }
            } else {
                //find a non holiday date for month of $request->inlieuofdate if possible.
                //only one date is allowed
                $inLieofDate = Carbon::parse($request->inLieofMonth)->format('Y-m-01');
                $compensGranted = new CompenGranted();
                $compensGranted->aadhaarid = $me->employee->aadhaarid;
                $compensGranted->leave_id = $leaf->id;
                $compensGranted->date_of_work = $inLieofDate;
                $compensGranted->is_for_extra_hours = true;
                $compensGranted->employee_id = $me->employee_id;
                $compensGranted->save();
            }
        } //compen or compen_for_extra
    }
    public function updateLeave(Request $request)
    {
       return $this->leaveStoreOrUpdate($request, true);
    }
    public function update(Request $request, Leaf $leaf)
    {

           return (new LeafResource($leaf))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaf->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function leaveApprove(Request $request)
    {
        //abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $leaf = Leaf::findOrFail($request->id);

        $approver = User::with(['employee', 'employee.designation'])->find(auth()->id());
        \Log::info('leaveApprove' . $approver);
        $designation = $approver->employee->designation->first()->designation->designation;

        $leaf->update([
            'active_status' => 'Y',
            'approver_employee_id' => $approver->employee_id,
            'approved_on' => now(),
            'approver_details' =>  "{$approver->employee->name}, {$designation} ({$approver->employee->pen})"


        ]);
        LeaveProcessService::processLeaveStatusChange($leaf);

        return (new LeafResource($leaf))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    public function leaveReturn(Request $request)
    {
        //abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        \Log::info('leaveReturn' . $request->id);
        $leaf = Leaf::findOrFail($request->id);

        \DB::transaction(function () use ($leaf) {
            $leaf->update([
                'active_status' => 'R',
                'owner_seat' => null,
                'owner_can_approve' => false,
                'forwarded_by_seat' => null,
                'approver_details' => null,
                'approved_on' => null,
                'approver_employee_id' => null,

            ]);
            LeaveProcessService::processLeaveStatusChange($leaf);
        });

        return (new LeafResource($leaf))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    public function leaveForward(Request $request)
    {
        //abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $leaf = Leaf::findOrFail($request->id);
        //find the owner seat which is the reporting officer of this employee's section
        $sectionMapping = EmployeeToSection::with('section')
            ->OnDate(now()->format('Y-m-d'))
            ->where('employee_id', $leaf->employee_id)->first();

        if (!$sectionMapping) {
            \Log::info('Employee is not mapped to any section');

            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Employee is not mapped to any section'
                ],
                400
            );
        }

        $owner = $sectionMapping->section->seat_of_controlling_officer_id;


        $leaf->update([
            'owner_seat' => $owner,
            'owner_can_approve' => true,
            'forwarded_by_seat' => $leaf->owner_seat,
        ]);

        return (new LeafResource($leaf))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function deleteLeave(Request $request)
    {
        //abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        \Log::info('deleteLeave' . $request->id);


        $leaf = Leaf::findOrFail($request->id);

        \DB::transaction(function () use ($leaf) {

            $leaf->update([
                'active_status' => 'C',
                'owner_seat' => null,
                'owner_can_approve' => false
            ]);

            LeaveProcessService::processLeaveStatusChange($leaf);
            $leaf->delete();
        });

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function precheckLeave(Request $request)
    {
        \Log::info($request->all());

        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if( !$request->start_date || !$request->leave_type)
        {
            return response()->json(
                [
                    'errors' =>  [],
                    'warnings' => [],
                ],
                200
            );
        }

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : Carbon::parse($request->start_date)->format('Y-m-d');

        $alreadyApplied =  LeaveProcessService::leaveAlreadyExistsForPeriod($start_date, $end_date, $me->employee->aadhaarid);
        $errors = [];
        $warnings = [];

        if ($alreadyApplied) {
            $errors[] = "Leave already applied for this date. (#{$alreadyApplied->id})";
        }
        //check if any holidays in between the period
        //$period = CarbonPeriod::create($request->start_date, $request->end_date);

        $holidays = GovtCalendar::getHolidaysForPeriod($start_date, $end_date)?->pluck('date');

        if ($holidays && $holidays->count()) {
            //if it is casual, then it is an error
            $str = "Period has holidays {$holidays->implode(', ')}  ";
          /*   if (
                $request->leave_type == 'casual' ||
                $request->leave_type == 'compen' ||
                $request->leave_type == 'compen_for_extra'
            ) {
                $warnings[] = $str;
            } else */ {
                if( $holidays->contains( $start_date) || $holidays->contains( $end_date) )
                {
                    $errors[] = $str; //date starts or ends with holidays
                } else {
                    $warnings[] = $str;
                }
            }
        }

        //find punchings between the period where punching count > 1 and warn

        if ( $start_date &&
             $request->leave_type != 'casual' ||
            ($request->leave_type == 'casual' && $request->fromType == 'full' )
        ) {

            $punchings_in_period = Punching::whereBetween('date', [$start_date, $end_date])
                ->where('aadhaarid', $me->employee->aadhaarid)
                ->where('punching_count', '>=', 1)
                ->pluck('date');

            if ($punchings_in_period && $punchings_in_period->count()) {

                //if leave is casual, then it can be half day. so ignore it
                $warnings[] = "Punching found on: {$punchings_in_period->implode(', ')}";

            }
        }

        //todo: check if the employee has enough leaves

        $prefix_holidays = [];
        $suffix_holidays = [];
        if ($start_date && $end_date  && in_array($request->leave_type, ['earned', 'commuted', 'halfpay',  'maternity', 'paternity', 'special_casual'])) {


            if( $start_date ){
                \Log::info('prefix_holidays');
                $prefix_holidays = GovtCalendar::getAdjacentHolidays($start_date, true);
            }
            if( $end_date /*&& $start_date*/){
                \Log::info('suffx_holidays');

                $suffix_holidays = GovtCalendar::getAdjacentHolidays($end_date,false);
            }


        }



        //ok to proceed.
        return response()->json(
            [
                'status' => 'success',
                'errors' =>  $errors,
                'warnings' => $warnings,
                'prefix_holidays' => $prefix_holidays,
                'suffix_holidays' => $suffix_holidays,
            ],
            200
        );
    }

    public function getEmployeeLeaves($aadhaarid)
    {

       $emp_leaves = Leaf::getEmployeeLeaves($aadhaarid);

       return response()->json(
            $emp_leaves,
            200
        );
    }

    // Function to find continuous sequences of adjacent dates
    function findAndRemoveAdjacentDates(&$dates) {

        $adjacentSequences = [];
        $currentSequence = [];

        for ($i = 0; $i < count($dates); $i++) {
            if (empty($currentSequence)) {
                $currentSequence[] = $dates[$i];
            } else {
                $lastDate = new DateTime(end($currentSequence));
                $currentDate = new DateTime($dates[$i]);
                $interval = $lastDate->diff($currentDate);

                if ($interval->days == 1) {
                    $currentSequence[] = $dates[$i];
                } else {
                    if (count($currentSequence) > 1) {
                        $adjacentSequences[] = $currentSequence;
                    }
                    $currentSequence = [$dates[$i]];
                }
            }
        }

        if (count($currentSequence) > 1) {
            $adjacentSequences[] = $currentSequence;
        }

        // Remove found dates from the original array
        $dates = array_diff($dates, array_merge(...$adjacentSequences));
        $dates = array_values($dates); // Re-index the array

        return $adjacentSequences;
    }

    public function getEmployeePendingLeaves($aadhaarid)
    {
        // leave_type: string;
        // leave_cat: string;
        // time_period: string | null;
      $today = Carbon::today()->format('Y-m-d');
       $punchings = Punching::where('aadhaarid', $aadhaarid)
       ->where('leave_id', null)
       ->where( 'date', '>=', '2024-05-01')
       ->where( 'date', '<', $today)
       ->Where('hint', '!=', 'clear')
       ->where( fn ($query) => $query->where('punching_count',  0)
            //->orWhere('is_unauthorised',  1)
            ->orWhere('hint', '!=', null)
        )
       ->orderBy('date', 'desc')
       ->get();
       $dates = $punchings->pluck('date')->toArray();

       //remove holidays from these dates
       if($dates && count($dates) > 0){
        $holidays = GovtCalendar::where('govtholidaystatus', 1)
                    ->wherein('date', $dates)->pluck('date')->toArray();

        \Log::info($holidays);
        $dates = array_diff($dates, $holidays);
        $dates = array_values($dates); // Re-index the array
         $punchings = $punchings->filter(function ($punching) use ($holidays) {
             return !in_array($punching->date, $holidays);
         });
       }



       $date_2_punchings = $punchings->mapWithKeys(function ($punching) {
           return [$punching->date => [
               'date' => $punching->date,
               'punching_count' => $punching->punching_count,
               'unauthorised' => $punching->unauthorised,
               'hint' => $punching->hint ? $punching->hint : '',
           ]];
       });

       $data = [];

       // Get the adjacent sequences and update the original array
       $adjacentSequences = $this->findAndRemoveAdjacentDates($dates);
       // Print the results
        foreach ($adjacentSequences as $sequence) {
            sort($sequence);
           //check if this sequence has same hint and punching count
            $hint = $date_2_punchings[$sequence[0]]['hint'];
            $punching_count = $date_2_punchings[$sequence[0]]['punching_count'];

            $same = true;
            foreach ($sequence as $p) {
                if ($date_2_punchings[$p]['hint'] != $hint || $date_2_punchings[$p]['punching_count'] != $punching_count) {
                    $same = false;
                    break;
                }
            }

            if ($same) {
                $data[] = [
                    'date' =>  implode(', ', $sequence),
                    'hint' => $hint,
                    'punching_count' => $punching_count,
                    'unauthorised' => $date_2_punchings[$sequence[0]]['unauthorised'],
                ];
            } else {
                foreach ($sequence as $p) {
                    $data[] = [
                        'date' => $p,
                        'hint' => $date_2_punchings[$p]['hint'],
                        'punching_count' => $date_2_punchings[$p]['punching_count'],
                        'unauthorised' => $date_2_punchings[$p]['unauthorised'],
                    ];
                }
            }
        }
        // Add the remaining dates
        foreach ($dates as $date) {
            $data[] = [
                'date' => $date,
                'hint' => $date_2_punchings[$date]['hint'],
                'punching_count' => $date_2_punchings[$date]['punching_count'],
                'unauthorised' => $date_2_punchings[$date]['unauthorised'],
            ];
        }


       return response()->json(
            $data,
            200
        );
    }


}
