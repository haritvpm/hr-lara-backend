<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Punching;
use App\Models\GovtCalendar;
use Illuminate\Http\Request;
use App\Models\AttendanceBook;
use App\Models\YearlyAttendance;
use App\Models\MonthlyAttendance;
use App\Services\EmployeeService;
use App\Http\Controllers\Controller;
use Auth;
class PunchingApiSectionDailyController extends Controller
{
    public function getpunchings(Request $request)
    {

        //jwt does not set these permissions??
        if(!Auth::user()->canDo('section_access') && !Auth::user()->canDo('can_view_all_section_attendance')){
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now()->startOfDay(); //today
        $date_str = $date->format('Y-m-d');

        [$me , $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        $isSecretary = Auth::user()->hasRole('secretary');
        $userIsSuperiorOfficer = $isSecretary;

        //get current logged in user's charges
        $employees_in_view = null;
        $empService = new EmployeeService();
        $employees = null;
        if (Auth::user()->canDo('can_view_all_section_attendance')) {
            // the user can view all section attendance
            $employees = $empService->getEmployeesToShowFromSeatsAndSectionsAndEmpIDs(
                $seat_ids_of_loggedinuser, $date_str,$date_str,null,null,null,null,null,null);

        }
        else {
            // the user can only view his/her section attendance
            $userIsSuperiorOfficer = true;


            if ($status != 'success') {
                return response()->json([
                    'status' => $status, 'message' => 'User not mapped to any seats'], 400);
            }

            //call employeeservice get loggedusersubordinate
            $employees = $empService->getLoggedUserSubordinateEmployees(
                $date_str,
                $date_str,
                $seat_ids_of_loggedinuser,
                $me
            );
        }

        $employees_in_view = $empService->employeeToResource(
            $employees, $seat_ids_of_loggedinuser,  $userIsSuperiorOfficer);

        if(!$employees_in_view){
            return response()->json(['status' => 'success', 'message' => 'No employees found'], 200);
        }

        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        $employees_in_view_mapped = $employees_in_view->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

        $data_monthly = MonthlyAttendance::forEmployeesInMonth($date, $aadhaarids);
        $data_yearly = YearlyAttendance::forEmployeesInYear($date, $aadhaarids);

        $calender_info = GovtCalendar::getCalenderInfoForDate($date_str);

        $punchings = Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave'])
            ->wherein('aadhaarid', $aadhaarids)
            ->where('date', $date_str)
            ->get();

        $data2 = [];
        $sections = [];
        $section_ids = [];

        foreach ($employees_in_view as $employee) {
            $aadhaarid = $employee['aadhaarid'];
            $item = [];
            $item['name'] = $employee['name'];
            $item['aadhaarid'] = $employee['aadhaarid'];

            if($employee['section_name']){
                $sections[] = $employee['section_name'];
                $section_ids[] = $employee['section_id'];
            }

            if ($data_monthly && $data_monthly->has($aadhaarid)) {
                $item['grace_limit'] = $data_monthly[$aadhaarid]['grace_minutes'];
                $item['total_grace_sec'] = $data_monthly[$aadhaarid]['total_grace_sec'];
                $item['total_extra_sec'] = $data_monthly[$aadhaarid]['total_extra_sec'];
                $item['total_grace_str'] = $data_monthly[$aadhaarid]['total_grace_str'];
                $item['total_extra_str'] = $data_monthly[$aadhaarid]['total_extra_str'];
                $item['total_grace_exceeded300_date'] = $data_monthly[$aadhaarid]['total_grace_exceeded300_date'];
            } else {
                $item['grace_limit'] = 300;
                $item['total_grace_sec'] = 0;
                $item['total_extra_sec'] = 0;
                $item['total_grace_exceeded300_date'] = null;
            }
            if ($data_yearly && $data_yearly->has($aadhaarid)) {
                $item['cl_marked'] = $data_yearly[$aadhaarid]['cl_marked'];
                $item['cl_submitted'] = $data_yearly[$aadhaarid]['cl_submitted'];
                $item['compen_marked'] = $data_yearly[$aadhaarid]['compen_marked'];
                $item['compen_submitted'] = $data_yearly[$aadhaarid]['compen_submitted'];
                $item['other_leaves_marked'] = $data_yearly[$aadhaarid]['other_leaves_marked'];
                $item['start_with_compen'] = $data_yearly[$aadhaarid]['start_with_compen'] ?? 0;
                $item['start_with_cl'] = $data_yearly[$aadhaarid]['start_with_cl'] ?? 0;

            } else {
                $item['cl_marked'] = 0;
                $item['cl_submitted'] = 0;
                $item['compen_marked'] = 0;
                $item['compen_submitted'] = 0;
                $item['other_leaves_marked'] = 0;
                $item['start_with_compen'] = 0;
                $item['start_with_cl'] = 0;
            }

            $item['logged_in_user_is_controller'] = $employees_in_view_mapped[$aadhaarid]['logged_in_user_is_controller'];
            $item['logged_in_user_is_section_officer'] = $employees_in_view_mapped[$aadhaarid]['logged_in_user_is_section_officer'];
            $item['logged_in_user_is_superior_officer'] = $employees_in_view_mapped[$aadhaarid]['logged_in_user_is_superior_officer'];

            $item['attendance_book_id'] = $employees_in_view_mapped[$aadhaarid]['attendance_book_id'];
            $item['attendance_book'] = $employees_in_view_mapped[$aadhaarid]['attendance_book'];
            $item['section'] = $employees_in_view_mapped[$aadhaarid]['section_name'];

            $emp_start_date = Carbon::parse($employee['start_date'])->startOfDay();
            $emp_end_date = $employee['end_date'] ? Carbon::parse($employee['end_date'])->endOfDay() : $emp_start_date->clone()->endOfYear();
            $item['in_section'] = $emp_start_date->lessThanOrEqualTo($date) && $emp_end_date->greaterThanOrEqualTo($date);

            // $punching = Punching::where('aadhaarid', $aadhaarid)->where('date', $date_str)->first();

            $punching = $punchings->where('aadhaarid', $aadhaarid)->first();

            if ($punching) {
                $item = [...$item, ...$punching->toArray(),
                'in_time' => substr($punching->in_datetime, 10, -3),
                'out_time' => substr($punching->out_datetime, 10, -3),];
            } else {
                $item['punching_count'] = 0;
            }

            //punching might have section empty. so overwrite with employee section
            $item['section'] = $employee['section_name'];
            $item['designation'] = $employee['designation'];

            if($item['name']==null){
                $item['name'] = $employee['name'];
                $item['designation'] = $employee['designation'];

            }

            $total_grace_exceeded300_date = $item['total_grace_exceeded300_date'] ? Carbon::parse($item['total_grace_exceeded300_date']) : null;
            if ($total_grace_exceeded300_date && $date->gte($total_grace_exceeded300_date) && $punching?->grace_sec > 60) {
                $item['grace_exceeded300_and_today_has_grace'] = true;
            } else {
                $item['grace_exceeded300_and_today_has_grace'] = false;
            }
            $data2[] = $item;
        }

        $attendancebooks = AttendanceBook::wherein('section_id', $section_ids)->pluck('title')
            ->transform(function ($item) {
                return "/{$item}";
            });

        $sections = [...$sections, ...$attendancebooks->toArray()];

        return response()->json([
            'date_dmY' => $date_str, // '2021-01-01'
            'is_today' => $date->isToday(),
            'is_future' => $date->gt(Carbon::now()),
            'is_holiday'=> $calender_info['holiday'] ?? false,
            'calender'=> $calender_info,
            'punchings' => $data2,
            'employees_in_view' => $employees_in_view,
            'sections' => array_values(array_unique($sections)),
        ], 200);
    }
}
