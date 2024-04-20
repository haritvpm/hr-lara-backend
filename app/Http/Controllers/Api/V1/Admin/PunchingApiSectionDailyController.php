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
use App\Models\GovtCalendar;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Services\PunchingService;
use App\Services\EmployeeService;
use App\Models\MonthlyAttendance;
use App\Models\Employee;

class PunchingApiSectionDailyController extends Controller
{

    public function getpunchings(Request $request)
    {

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now(); //today
        $date_str =  $date->format('Y-m-d');
        //get current logged in user's charges
        $me = User::with('employee')->find(auth()->id());

        if ($me->employee_id == null) {
            return response()->json(['status' => 'No linked employee'], 400);
        }
        $seat_ids_of_loggedinuser = EmployeeToSeat::where('employee_id', $me->employee_id)->get()->pluck('seat_id');

        if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser) == 0) {
            return response()->json(['status' => 'No seats in charge'], 400);
        }

        //call employeeservice get loggedusersubordinate
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $date_str,
            $date_str,
            $seat_ids_of_loggedinuser,
            $me
        );


        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        $employees_in_view_mapped = $employees_in_view->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

        $data_monthly = MonthlyAttendance::forEmployeesInMonth($date, $aadhaarids);

        //this should be done when we finish aebas fetch
        // $data_monthly = (new PunchingService())->calculate($date_str, $aadhaarids)->mapwithKeys(function ($item) {
        //     return [$item['aadhaarid'] => $item];
        // });


        $data2 = Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave'])
            ->wherein('aadhaarid', $aadhaarids)
            ->where('date', $date_str)
            ->get();
        //for each employee get
        $data2->transform(function ($item, $key) use ($data_monthly, $employees_in_view_mapped) {
            $aadharid = $item['aadhaarid'];
            $item['total_grace_sec'] = $data_monthly[$aadharid]['total_grace_sec'];
            $item['total_extra_sec'] = $data_monthly[$aadharid]['total_extra_sec'];
            $item['cl_taken'] = $data_monthly[$aadharid]['cl_taken'];

            $item['logged_in_user_is_controller'] = $employees_in_view_mapped[$aadharid]['logged_in_user_is_controller'];
            $item['logged_in_user_is_section_officer'] = $employees_in_view_mapped[$aadharid]['logged_in_user_is_section_officer'];

            $item['attendance_book_id'] = $employees_in_view_mapped[$aadharid]['attendance_book_id'];
            $item['attendance_book'] = $employees_in_view_mapped[$aadharid]['attendance_book'];
            $item['section'] = $employees_in_view_mapped[$aadharid]['section_name'];

            return $item;
        });

        return response()->json([
            'date_dmY' => $date->format('d-m-Y'), // '2021-01-01'
            'is_today' => $date->isToday(),
            'is_future' => $date->gt(Carbon::today()),
            'punchings' => $data2,
            'employees_in_view' =>  $employees_in_view,
            // '$aadhaarids' => $aadhaarids,
        ], 200);
    }


}
