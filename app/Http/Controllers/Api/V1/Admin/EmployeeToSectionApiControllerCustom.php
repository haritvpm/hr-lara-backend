<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Services\EmployeeService;
use App\Models\Section;
use App\Models\EmployeeToSection;
use App\Models\AttendanceBook;
use App\Models\AttendanceRouting;
use App\Models\Employee;
use App\Models\EmployeeToFlexi;
use App\Models\FlexiApplication;
use App\Models\OfficeTime;
use Attribute;
use Carbon\Carbon;

class EmployeeToSectionApiControllerCustom extends Controller
{
    //get current logged in user's flexi settings so he can request for changes
    public function getUserSettings()
    {

       // $employee = Employee::find($employee_id);
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();
        $employee_id = $me->employee_id;

        $today = Carbon::today()->format('Y-m-d');

        $officeTimes = OfficeTime::orderBy( 'with_effect_from', 'desc')->get();
        $emp_flexi_time = EmployeeToFlexi::getEmployeeFlexiTime($today, $employee_id);
        $emp_flexi_time_upcoming = EmployeeToFlexi::getEmployeeUpcomingFlexiTime($employee_id);


        $employee_section_map = EmployeeToSection::onDate($today)
        ->with(['employee'])
        //->with(['employee', 'attendance_book', 'section', 'employee.seniority'])
        ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($today) {

            $q->DesignationDuring($today)->with(['designation', 'designation.default_time_group']);
        }])
        ->where('employee_id', $employee_id)
        ->first();



        $time_group = $employee_section_map?->designation?->default_time_group?->groupname ?? 'default';
            //$emp_office_time = OfficeTime::where('groupname', $time_group)->first();

        $data =

             [
                'time_group' => $employee_section_map?->designation?->default_time_group?->groupname ?? 'default',
                //'seniority' => $emp->employee?->seniority?->sortindex,
                'flexi_minutes_current' => $emp_flexi_time?->flexi_minutes ?? 0,
                'flexi_time_wef_current' => $emp_flexi_time?->with_effect_from ?? null,
                'flexi_minutes_upcoming' => $emp_flexi_time_upcoming?->flexi_minutes ?? 0,
                'flexi_time_wef_upcoming' => $emp_flexi_time_upcoming?->with_effect_from ?? null,
            ];


        //also get reporting officer seat, controller, and all seat above this user in routing
        $controller = $employee_section_map?->section?->seat_of_controlling_officer_id ;


        $seats = AttendanceRouting::getForwardableSeats($controller, null, $seat_ids_of_loggedinuser);

        $prev_flexi_applications = FlexiApplication::where('employee_id', $employee_id)->orderby('created_at', 'desc')->get();

        return response()->json([
            'forwardable_seats' => $seats,
            'employee_setting' => $data,
            'officeTimes' => $officeTimes,
            'prev_flexi_applications'  => $prev_flexi_applications,
        ], 200);
    }

    public function getUserFlexiApplications()
    {
        $officeTimes = OfficeTime::orderBy( 'with_effect_from', 'desc')->get();
        $today = Carbon::today()->format('Y-m-d');

        $user = User::find(auth()->user()->id);
        $employee_id = $user->employee_id;
        $prev_flexi_applications = FlexiApplication::with('owner_seat')->where('employee_id', $employee_id)->orderby('created_at', 'desc')->get()
       /* ->transform( function($application) use ($today, $employee_id){
            $emp_flexi_time = EmployeeToFlexi::getEmployeeFlexiTime($today, $employee_id);
            $application['owner_seat_name'] = $application->owner_seat?->name ?? '';

            $application['time_group' ] = $employee_section_map?->designation?->default_time_group?->groupname ?? 'default';
            //'seniority' => $emp->employee?->seniority?->sortindex,
            $application['flexi_minutes_current' ] =$emp_flexi_time?->flexi_minutes ?? 0;
            $application['flexi_time_wef_current'] = $emp_flexi_time?->with_effect_from ?? null;
            return $application;
        })*/;


        return response()->json([
            'flexi_applications'  => $prev_flexi_applications,
        ], 200);

    }
    public function storeUserFlexiApplication( Request $request)
    {
       // \Log::info($request->all());
        $user = User::find(auth()->user()->id);
        $employee_id = $user->employee_id;
        $flexi_minutes = $request->flexi_minutes;
        $with_effect_from = Carbon::parse($request->wef)->format('Y-m-d');
        $owner_seat = $request->forwardto;

         //check if there are any pending applications
        //if there are, then user cannot apply for another one
        $pending_applications = FlexiApplication::where('employee_id', $employee_id)->where('approved_on', null)->count();
        if($pending_applications > 0){
            return response()->json(['status' => 'failed', 'message' => 'You have a pending application. Await its approval or Delete it'], 400);
        }


        $flexi_application = FlexiApplication::create([
            'aadhaarid' => $user->employee->aadhaarid,
            'employee_id' => $employee_id,
            'flexi_minutes' => $flexi_minutes,
            'with_effect_from' => $with_effect_from,
            'owner_seat' => $owner_seat,
            'time_option_str' => $request->time_option_str,
            'time_option_current_str' => $request->time_option_current_str,
        ]);

        return response()->json(['status' => 'success'], 200);

    }


    public function deleteUserFlexiApplication( Request $request)
    {
        $id = $request->id;


        //do this in a transaction, so approver cannot approve it while we are deleting it

        \DB::transaction( function() use ($id){
            $flexi_application = FlexiApplication::find($id);

            if(!$flexi_application){
                return response()->json(['status' => 'failed', 'message' => 'Application not found'], 400);
            }
            //also make sure it has not been approved during delete
            if($flexi_application->approved_on){
                return response()->json(['status' => 'failed', 'message' => 'Application already approved'], 400);
            }

            $flexi_application->delete();
        });

        return response()->json(['status' => 'success'], 200);
    }

    //get employees mapped to sections that this logged in user is a reporting officer of
    public function getUserSectionEmployees()
    {
        //get employees mapped to sections that this logged in user is a reporting officer of
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if ($status !== 'success') {
            return response()->json(['status' => $status], 400);
        }

        $date  = Carbon::today();
        $date_str = $date->format('Y-m-d');
        $employees_under_my_section = (new EmployeeService())->getLoggedInUserSectionEmployees(
            $date_str,
            $date_str,
            $seat_ids_of_loggedinuser,
            $me
        );

        if (!$employees_under_my_section) {
          //  return response()->json(['status' => 'No employees under your section'], 200);
        }

        $sections = Section::with('sectionAttendanceBooks')
        // ->when($employees_under_my_section, function ($query) {
        //     return $query->wherein('id', $employees_under_my_section->pluck('section_id'));
        // })
        ->wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)
        ->orwherein('seat_of_controlling_officer_id', $seat_ids_of_loggedinuser)
        ->get()->unique();

        $attendancebooks = AttendanceBook::wherein('section_id',  $sections->pluck('id'))->get();

        $officeTimes = OfficeTime::orderBy( 'with_effect_from', 'desc')->get();

        return response()->json([
            'employees_under_my_section' => $employees_under_my_section,
            'sections' => $sections,
            'attendancebooks' =>  $attendancebooks,
            'officeTimes' => $officeTimes,
        ], 200);
    }
    public function endPosting(Request $request)
    {
        $employeetosection_id = $request->id;

        $employeetosection = EmployeeToSection::find($employeetosection_id);

        $end_date = $request->end_date;

        //check if end_date is before start_date
        if(Carbon::parse($end_date)->lt(Carbon::parse($employeetosection->start_date))){
            return response()->json(['status' => 'failed', 'message' => 'End date cannot be before start date'], 400);
        }


        $date_str = Carbon::parse($end_date)->format('Y-m-d');
        $status = $employeetosection->update(['end_date' => $date_str]);

        return response()->json(['status' => $status], 200);
    }
    public function editSetting(Request $request)
    {
        $employee_id = $request->id;
        return EmployeeService::createOrUpdateFlexi($employee_id, $request->flexi_minutes, $request->wef);
    }

    public function getUnpostedEmployees(Request $request)
    {
        $employees_already_posted = EmployeeToSection::where('end_date', null)->pluck('employee_id')->unique();
        $employees = Employee::getEmployeesWithAadhaarDesig(true, $employees_already_posted, false);
        $employees_last_posting = EmployeeToSection::wherein('employee_id', $employees->pluck('id'))->orderby('end_date','desc')->get()->groupby('employee_id');
        $employees->transform( function($employee) use ($employees_last_posting) {
            $last_posting = $employees_last_posting->get($employee['id'])?->first() ?? null;
            $employee['last_posting_end_date'] = $last_posting?->end_date ?? '';
            return $employee;
        });

        return response()->json($employees, 200);
    }


    public function getUnpostedEmployeesAjax(Request $request)
    {
        //note, there can be multiple mappings
        $employees_already_posted = EmployeeToSection::where('end_date', null)->pluck('employee_id')->unique();

        $name = $request->name;
//\Log::info($name);
        $employees = Employee::with(['designation'])
                    ->where( function($query) use ($name) {
                        $query->where('name', 'like', '%'.$name.'%')
                        ->orwhere('pen', 'like', '%'.$name.'%')
                        ->orwhere('aadhaarid', 'like', '%'.$name.'%');
                    })
                    ->whereNotIn('id', $employees_already_posted)
                    ->where(fn ($query) => $query->where('status', 'active')->orWherenull('status'))
                    ->orderby('name')
                    ->get();
        $employees_last_posting = EmployeeToSection::wherein('employee_id', $employees->pluck('id'))->orderby('end_date','desc')->get()->groupby('employee_id');

        /*$employees = $employees->transform( function($employee)  {
            \Log::info($employee);
            $desig = $employee?->designation?->first()?->designation->designation;
            $employee['last_posting_end_date'] = $employee->employee_section_mapping?->end_date ?? '';
            $employee['name'] = "{$employee->aadhaarid} - {$employee->name} ({$desig})";
            $employee['id'] = $employee->id;

            return $employee;
        });
        */
        $employees->transform( function($employee) use ($employees_last_posting) {
            $last_posting = $employees_last_posting->get($employee['id'])?->first() ?? null;
            $desig = $employee?->designation?->first()?->designation->designation;
            $employee['last_posting_end_date'] = $last_posting?->end_date ?? '';
            $employee['name'] = "{$employee->aadhaarid} - {$employee->name} ({$desig})";
            $employee['id'] = $employee->id;
            return $employee;
        });

        return response()->json($employees, 200);
    }
    public function saveUserSectionEmployee(Request $request)
    {
        //$employee_id = $request->employee_id;
        \Log::info($request->employee);
        $employee_id = $request->employee['id'];
        $section_id = $request->section_id;
        $attendance_book_id = $request->attendance_book_id;
        $start_date =  substr($request->start_date,0,10); //this is in UTC format. remove trailing part
\Log::Info( $start_date);


        //check if start date overlaps with any other posting of this employee
        $employee_already_posted = EmployeeToSection::where('employee_id', $employee_id)->onDate($start_date)->first();
        if($employee_already_posted){
            return response()->json(['status' => 'failed', 'message' => 'Employee already posted to a section during this period'], 400);
        }


        $employeetosection = EmployeeToSection::create([
            'employee_id' => $employee_id,
            'section_id' => $section_id,
            'attendance_book_id' => $attendance_book_id,
            'start_date' => $start_date,
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}
