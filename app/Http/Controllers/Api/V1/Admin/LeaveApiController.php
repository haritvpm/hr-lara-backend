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
class LeaveApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leaf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeafResource(Leaf::with(['employee'])->get());
    }

    public function store(Request $request)
    {
        $me = User::with('employee')->find( auth()->user()->id );

        

        \Log::info('store leaf');
        \Log::info($request->all());

        //find the owner seat which is the reporting officer of this employee's section
        $sectionMapping = EmployeeToSection::with('section')->OnDate(now()->format('Y-m-d'))->where('employee_id', $me->employee_id)->first();
        if( !$sectionMapping ){
                \Log::info('Employee is not mapped to any section');

            return response()->json(['error' => 'Employee is not mapped to any section'], 400);
        }
        \Log::info($sectionMapping);

        $leaf = null;
        \DB::transaction(function () use ( &$leaf, $request, $me,  $sectionMapping) {
            
        $leaf = Leaf::create(
            [
                'is_aebas_leave' => false,
                'aadhaarid' => $me->employee->aadhaarid,
                'employee_id'=> $me->employee_id,
                'leave_type' => $request->leaveType,
                'start_date' => Carbon::parse($request->fromDate)->format('Y-m-d'),
                'end_date'  => Carbon::parse($request->toDate)->format('Y-m-d'),
                'reason' => $request->reason,
                'active_status' => 'N',
                'last_updated' => null,
                'creation_date' => now(),
                'created_by_aadhaarid' => $me->employee->aadhaarid,
                'processed' => false,
                'owner_seat' =>  $sectionMapping->section->seat_of_reporting_officer_id,
                'remarks' =>null,
                'start_date_type' => $request->fromType,
                'end_date_type'=> $request->toType,
                'leave_count' => $request->leave_count,
                
            ]
        );

        $inLieofDates = Collect($request->inlieuofdates)->map(function($date){
            return Carbon::parse($date)->format('Y-m-d');
        });
       
        if( $leaf->leave_type == 'compen'){
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
}
