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
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeToSectionApiControllerCustom extends Controller
{
    public function getUserSectionEmployees()
    {
        //get employees mapped to sections that this logged in user is a reporting officer of
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if ($status != 'success') {
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
        ->get()->unique();

        $attendancebooks = AttendanceBook::wherein('section_id',  $sections->pluck('id'))->get();

        return response()->json([
            'employees_under_my_section' => $employees_under_my_section,
            'sections' => $sections,
            'attendancebooks' =>  $attendancebooks,
        ], 200);
    }
    public function endPosting(Request $request)
    {
        $employeetosection_id = $request->id;

        $employeetosection = EmployeeToSection::find($employeetosection_id);

        $end_date = $request->end_date;
        $date_str = Carbon::parse($end_date)->format('Y-m-d');
        $status = $employeetosection->update(['end_date' => $date_str]);

        return response()->json(['status' => $status], 200);
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
    public function saveUserSectionEmployee(Request $request)
    {
        $employee_id = $request->employee_id;
        $section_id = $request->section_id;
        $attendance_book_id = $request->attendance_book_id;
        $start_date =  substr($request->start_date,0,10); //this is in UTC format. remove trailing part
\Log::Info( $start_date);
        $employeetosection = EmployeeToSection::create([
            'employee_id' => $employee_id,
            'section_id' => $section_id,
            'attendance_book_id' => $attendance_book_id,
            'start_date' => $start_date,
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}
