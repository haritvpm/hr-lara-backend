<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRequest;
use App\Http\Requests\UpdatePunchingRequest;
use App\Http\Resources\Admin\PunchingResource;
use App\Models\User;
use App\Models\PunchingTrace;
use App\Models\EmployeeToSeat;
use App\Models\Punching;
use App\Models\Section;
use App\Models\EmployeeToSection;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Services\PunchingService;


class PunchingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('punching_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingResource(Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section'])->get());
    }

    public function store(StorePunchingRequest $request)
    {
        $punching = Punching::create($request->all());

        return (new PunchingResource($punching))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Punching $punching)
    {
        abort_if(Gate::denies('punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingResource($punching->load(['employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section']));
    }

    public function update(UpdatePunchingRequest $request, Punching $punching)
    {
        $punching->update($request->all());

        return (new PunchingResource($punching))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /*
    For a list of employee ids, finds the seats and get sections related to that seat and then employees mppaed to that sections
    */
    public function getEmployeeSectionMappingForEmployees( $emp_ids, $date, $seat_ids )
    {
        
        $sections_under_charge = Section::wherein('seat_of_controlling_officer_id', $seat_ids)
            ->orwherein('seat_of_reporting_officer_id', $seat_ids)
            ->orwherein('js_as_ss_employee_id',$emp_ids)->get();

        if ($sections_under_charge == null) { return null;  }
        
        $employee_section_maps = EmployeeToSection::during($date)
            ->with(['employee', 'attendance_book', 'section'])
            ->wherein('section_id', $sections_under_charge->pluck('id'))
            ->get();

      //  \Log::info('in getEmployeeSectionMappingForEmployees 3');

        return $employee_section_maps->count() ? $employee_section_maps : null ;

    }

    public function getpunchings(Request $request)
    {

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now(); //today

        //need to move things to services later

        //get current logged in user's charges
        $me = User::with('employee')->find(auth()->id());

        if ($me->employee_id == null) {
            return response()->json(['status' => 'No linked employee'], 400);
        }
        $seat_ids_already_fetched = collect();
        $seat_ids_of_loggedinuser = EmployeeToSeat::with('seat')->where('employee_id', $me->employee_id)->get()->pluck('seat.id');

        if ($seat_ids_of_loggedinuser == null) {
            return response()->json(['status' => 'No seats in charge'], 400);
        }

        $employee_section_maps = $this->getEmployeeSectionMappingForEmployees([$me->employee_id], $date, $seat_ids_of_loggedinuser);
        $seat_ids_already_fetched = $seat_ids_already_fetched->concat($seat_ids_of_loggedinuser);

        if(!$employee_section_maps){
            return response()->json(['status' => 'No employee found'], 200);
        }

        $data = collect();
        $data = $data->concat($employee_section_maps);

        $emp_ids= $employee_section_maps->pluck('employee.id') ;

        while(count($emp_ids))
         {           
            $seat_ids = EmployeeToSeat::with(['seat'])->wherein('employee_id', $emp_ids)
                            ->whereNotIn('seat_id', $seat_ids_already_fetched)
                            ->get()->pluck('seat.id');
                        
        
            if(!$seat_ids) break;

            $employee_section_maps = $this->getEmployeeSectionMappingForEmployees( $emp_ids, $date, $seat_ids );
   
            if(!$employee_section_maps) break;
            
            $seat_ids_already_fetched = $seat_ids_already_fetched->concat($seat_ids);

            $emp_ids= $employee_section_maps->pluck('employee.id') ;
            $data = $data->concat($employee_section_maps);
            
        }
     

        //map EmployeeToSection to a format like DTO
        $data->transform(function ($employeeToSection, $key) use ($seat_ids_of_loggedinuser) {
                   
            return [
                'employee_id' => $employeeToSection->employee_id,
                'name' => $employeeToSection->employee->name,
                'aadhaarid' => $employeeToSection->employee->aadhaarid,
                'attendance_book_id' => $employeeToSection->attendance_book_id,
                'attendance_book' => $employeeToSection->attendance_book,
                'section_id' => $employeeToSection->section_id,
                'section_name' => $employeeToSection->section->name,
                'works_nights_during_session'  => $employeeToSection->section->works_nights_during_session,
                'seat_of_controlling_officer_id'  => $employeeToSection->section->seat_of_controlling_officer_id,
                'logged_in_user_is_controller' => 
                $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id),
                
                
            ];
        
        });

        //   $data = (new PunchingService())->calculate($date);
        return response()->json([
            'status' => 'success',
        //    'seats' => $seat_ids,
        //    'sections_under_charge' => $sections_under_charge,
            'employee_section_maps' => $data->unique('employee_id'),
            //  'punchings' => $data
        ], 200);

        //  \Log::info("got" . $request->date);
        /*
      $punchingstest = Punching::where('date', $date->format('Y-m-d'))->get();
      return response()->json([
        'status' => 'success',
        'punchings' => $punchingstest
        ]);

        */
    }
}
