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
use Carbon\Carbon;

class EmployeeToSectionApiControllerCustom extends Controller
{
    public function getUserSectionEmployees()
    {
        //get employees mapped to sections that this logged in user is a reporting officer of
        [$me , $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if($status != 'success'){
            return response()->json(['status' => $status], 400);
        }

        $date  = Carbon::today();
        $date_str = $date->format('Y-m-d');
        $employees_under_my_section = (new EmployeeService())->getLoggedInUserSectionEmployees(
            $date_str,$date_str,
            $seat_ids_of_loggedinuser,
            $me
        );

        $sections = Section::wherein('id',$employees_under_my_section->pluck('section_id')->unique())->get();
        $attendancebooks = AttendanceBook::where('id',$employees_under_my_section->pluck('attendance_book_id')->unique() )->get();
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
   

}
