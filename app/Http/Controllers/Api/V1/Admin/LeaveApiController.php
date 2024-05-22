<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeafRequest;
use App\Http\Requests\UpdateLeafRequest;
use App\Http\Resources\Admin\LeafResource;
use App\Models\EmployeeToSection;
use App\Models\User;
use App\Models\Leaf;
use App\Models\CompenGranted;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Services\LeaveProcessService;
use App\Services\PunchingCalcService;
use App\Models\Punching;

class LeaveApiController extends Controller
{
    private function LeafToResource($leaf)
    {
        $compensGranted = CompenGranted::where('leave_id', $leaf->id)->get();
        $inLieofDates = [];
        $inLieofMonth = null;
        if( $leaf->leave_type == 'compen'){
            $inLieofDates = $compensGranted->map(function($item){
                return $item->date_of_work;
            });
        } else  if( $leaf->leave_type == 'compen_for_extra'){
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
                'created_at' => $leaf->created_at,
                'fromType' => $leaf->leave_cat == 'H' ? $leaf->time_period : 'full',
                'multipleDays' => $leaf->start_date != $leaf->end_date,
                'inLieofDates' => $inLieofDates,
                'inLieofMonth' => $inLieofMonth,
                'employee' => $leaf->employee,
                'owner_seat' =>  $leaf->owner,
                'owner_can_approve' => $leaf->owner_can_approve,

            ];

    }
    public function index()
    {
       // abort_if(Gate::denies('leaf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       //find all leaves where owner_seat is the logged in user's seat
       [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if( $status == 'error'){
            return response()->json(
            [
                'status' => 'error',
                'message' => 'User has no seats mapped'
            ], 400);
        }

        $leaves = Leaf::with(['employee', 'compensGranted', 'employee.designation'])
                ->wherein('owner_seat', $seat_ids_of_loggedinuser)
                ->get()->transform(function($leaf){
                    return $this->LeafToResource($leaf);
                });


        return response()->json(
            [
                'status' => 'success',
                'leaves' => LeafResource::collection($leaves)

            ], 200);
    }

    public function store(Request $request)
    {
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        $alreadyApplied =  LeaveProcessService::leaveAlreadyExistsForPeriod($request->start_date, $request->end_date, $me->employee->aadhaarid);

        if( $alreadyApplied ){
            return response()->json(
                [  'status' => 'error',  'message' => "Leave already applied for this date. (#{$alreadyApplied->id})" ], 400);
        }

        //ok to proceed.
        \Log::info($request->all());

        //find the owner seat which is the reporting officer of this employee's section
        $sectionMapping = EmployeeToSection::with('section')->OnDate(now()->format('Y-m-d'))->where('employee_id', $me->employee_id)->first();
        if( !$sectionMapping ){
            return response()->json(
                [  'status' => 'error', 'message' => 'Employee is not mapped to any section'], 400);
        }

        $leaf = null;
        \DB::transaction(function () use ( &$leaf, $request, $me, $seat_ids_of_loggedinuser,  $sectionMapping) {

            //when SO, who is the reporting officer submits, has to submit to controller
            $owner = $sectionMapping->section->seat_of_reporting_officer_id;
            $owner_can_approve = false;
            if( $seat_ids_of_loggedinuser->contains($owner) == true){
                $owner = $sectionMapping->section->seat_of_controlling_officer_id;
                $owner_can_approve = true;
            }
            //TODO.if compen, check if this date is not already taken where is_for_extra_hours = false
            $leaf = Leaf::create(
                [
                    'is_aebas_leave' => false,
                    'aadhaarid' => $me->employee->aadhaarid,
                    'employee_id'=> $me->employee_id,
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
                    'remarks' =>null,
                   // 'start_date_type' => $request->fromType,
                   // 'end_date_type'=> $request->toType,
                    'leave_count' => $request->leave_count,
                    'leave_cat' => ($request->fromType == 'an' ||  $request->fromType == 'fn') ? 'H' : 'F', //dummy required value
                    'time_period' => $request->fromType == 'an' ? 'AN' : ( $request->fromType == 'fn' ? 'FN' : null), //dummy required value

                ]
            );

            if( $request->leave_type == 'compen' || $request->leave_type == 'compen_for_extra'){

                if( $leaf->leave_type == 'compen'){
                    $inLieofDates = Collect($request->inlieuofdates)->map(function($date){
                        return Carbon::parse($date)->format('Y-m-d');
                    });
                    foreach($inLieofDates as $date){
                        $compensGranted = new CompenGranted();
                        $compensGranted->aadhaarid = $me->employee->aadhaarid;
                        $compensGranted->leave_id = $leaf->id;
                        $compensGranted->date_of_work = $date;
                        $compensGranted->is_for_extra_hours = false;
                        $compensGranted->employee_id = $me->employee_id;
                        $compensGranted->save();
                    }
                }
             else {
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

            LeaveProcessService::processNewLeave($leaf);

        });




         return (new LeafResource($leaf))
             ->response()
             ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Leaf $leaf)
    {
        //abort_if(Gate::denies('leaf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //check if this leave is for the logged in user
        $me = User::with('employee')->find(auth()->id());

        if( $leaf->aadhaarid != $me->employee->aadhaarid || $leaf->owner_seat != null){
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Leave does not belong to logged in user'
                ], 400);
        }
        $leaf->load(['employee']);

        //return new LeafResource($this->LeafToResource($leaf));
        return (new LeafResource($this->LeafToResource($leaf)))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function update(UpdateLeafRequest $request, Leaf $leaf)
    {
        $leaf->update($request->all());

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

        $leaf->update(['active_status' => 'Y']);
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

        \DB::transaction(function () use ( $leaf) {
            $leaf->update([
                'active_status' => 'R',
                'owner_seat' => null,
                'owner_can_approve' => false
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
         ->where('employee_id', $leaf->employee_id )->first();

         if( !$sectionMapping ){
                 \Log::info('Employee is not mapped to any section');

             return response()->json(
                 [
                     'status' => 'error',
                     'message' => 'Employee is not mapped to any section'
                 ], 400);
         }

        $owner = $sectionMapping->section->seat_of_controlling_officer_id;


        $leaf->update([
           'owner_seat' => $owner,
           'owner_can_approve' => true,
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

        \DB::transaction(function () use ( $leaf) {

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
}
