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

        $leaves = Leaf::with(['employee', 'compensGranted', 'employee.designation'])->wherein('owner_seat', $seat_ids_of_loggedinuser)->get();
            

        return response()->json(
            [
                'status' => 'success',
                'leaves' => LeafResource::collection($leaves)
                   
            ], 200); 
    }

    public function store(Request $request)
    {
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        $leave_start_date = Carbon::parse($request->fromDate);
        $leave_end_date = $request->toDate ? Carbon::parse($request->toDate) : Carbon::parse($request->fromDate);
/*
        $leavePeriod = CarbonPeriod::create($leave_start_date, $leave_end_date);
        foreach ($leavePeriod as $leavedate) {
            //check if leave is applied for this leavedate
            $alreadyApplied = Leaf::where('employee_id', $request->employee_id)
                                ->where('start_date', '<=', $leavedate)
                                ->where('end_date', '>=', $leavedate)
                                ->wherein('active_status', ['N', 'Y'])
                                ->first();

            if( $alreadyApplied ){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Leave already applied for this date'
                    ], 400);
            }                            
            
        }
        */
        $alreadyApplied = Leaf::where( function($query) use ($leave_start_date, $leave_end_date){
                                $query->whereBetween('start_date', [$leave_start_date, $leave_end_date])
                                ->orWhereBetween('end_date', [$leave_start_date, $leave_end_date]);
                            })
                            ->where('aadhaarid', $me->employee->aadhaarid)
                            ->wherein('active_status', ['N', 'Y'])
                            ->first();

        if( $alreadyApplied ){
            return response()->json(
                [
                    'status' => 'error',
                    'message' => "Leave already applied for this date {$alreadyApplied->id}"
                ], 400);
        }   
        //ok to proceed. 


        \Log::info('store leaf');
        \Log::info($request->all());

        //find the owner seat which is the reporting officer of this employee's section
        $sectionMapping = EmployeeToSection::with('section')->OnDate(now()->format('Y-m-d'))->where('employee_id', $me->employee_id)->first();
        if( !$sectionMapping ){
                \Log::info('Employee is not mapped to any section');

            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Employee is not mapped to any section'
                ], 400);
        }
        \Log::info($sectionMapping);

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
                    'leave_type' => $request->leaveType,
                    'start_date' => Carbon::parse($request->fromDate)->format('Y-m-d'),
                    'end_date'  => $request->toDate ? Carbon::parse($request->toDate)->format('Y-m-d') : Carbon::parse($request->fromDate)->format('Y-m-d'),
                    'reason' => $request->reason,
                    'active_status' => 'N',
                    'last_updated' => null,
                    'creation_date' => now(),
                    'created_by_aadhaarid' => $me->employee->aadhaarid,
                    'processed' => false,
                    'owner_seat' =>  $owner,
                    'owner_can_approve' => $owner_can_approve,
                    'remarks' =>null,
                    'start_date_type' => $request->fromType,
                    'end_date_type'=> $request->toType,
                    'leave_count' => $request->leaveCount,
                    'leave_cat' => ($request->fromType == 'an' ||  $request->fromType == 'fn') ? 'H' : 'F', //dummy required value
                    'time_period' => $request->fromType == 'an' ? 'AN' : ( $request->fromType == 'fn' ? 'FN' : null), //dummy required value

                ]
            );

            if( $request->leaveType == 'compen' || $request->leaveType == 'compen_for_extra'){

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
                $inLieofDate = Carbon::parse($request->inLieofMonth)->format('Y-m-d');
                $compensGranted = new CompenGranted();
                $compensGranted->aadhaarid = $me->employee->aadhaarid;
                $compensGranted->leave_id = $leaf->id;
                $compensGranted->date_of_work = $inLieofDate;
                $compensGranted->is_for_extra_hours = true;
                $compensGranted->employee_id = $me->employee_id;
                $compensGranted->save();

            }

            } //compen or compen_for_extra

            LeaveProcessService::processLeave($leaf);

        });

        


         return (new LeafResource($leaf))
             ->response()
             ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeafResource($leaf->load(['employee']));
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

        return (new LeafResource($leaf))
        ->response()
        ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    public function leaveReturn(Request $request)
    {
        //abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        \Log::info('leaveReturn' . $request->id);
        $leaf = Leaf::findOrFail($request->id);

        $leaf->update([
            'active_status' => 'R',
            'owner_seat' => null,
            'owner_can_approve' => false
        ]);

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

        \DB::transaction(function () use ( &$leaf) {

            //find all punchings and delete leave_id
            $punchings = Punching::where('leave_id', $leaf->id)
                        ->update(['leave_id' => null]);
            // foreach($punchings as $punching){
            //     $punching->leave_id = null;
            //     $punching->save();
            // }
            //delete all compen_granted
            $compensGranted = CompenGranted::where('leave_id', $leaf->id)?->delete();
            $leaf->delete();
            
            $leave_start_date = Carbon::parse($leaf->start_date);
            $leave_end_date = Carbon::parse($leaf->end_date);

            $leavePeriod = CarbonPeriod::create($leave_start_date, $leave_end_date);
            $punchingCalcService = new PunchingCalcService();

            foreach ($leavePeriod as $leavedate) {
                //recalculate monthly attendance for all dates of this leave
                $punchingCalcService->calculate($leavedate->format('Y-m-d'), [$leaf->aadhaarid]);
            }

            //recalculate monthly attendance for all dates of this leave
            $punchingCalcService = new PunchingCalcService();

            //also update hint

        });



        return response(null, Response::HTTP_NO_CONTENT);
    }
}
