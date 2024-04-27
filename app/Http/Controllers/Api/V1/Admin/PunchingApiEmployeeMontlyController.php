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

class PunchingApiEmployeeMontlyController extends Controller
{
    public function getemployeeMonthlyPunchings(Request $request)
    {
        $aadhaarid = $request->aadhaarid;
        $date = $request?->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now(); //today
        $start_date = $date->startOfMonth()->format('Y-m-d');
        $end_date = $date->endOfMonth()->format('Y-m-d');
        //$date_str = $date->format('Y-m-d');
        $employee = Employee::where('aadhaarid', $aadhaarid)->first();
        if (!$employee) {
            return response()->json(['status' => 'Employee not found'], 400);
        }


        $punchings = Punching::with(['punchin_trace', 'punchout_trace', 'leave'])
            ->where('aadhaarid', $aadhaarid)
            ->whereBetween('date', [$start_date, $end_date])
            ->get()->mapwithKeys(function ($item) {
                return [$item['date'] => $item];
            });


        [$me , $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if($status != 'success'){
            return response()->json(['status' => $status], 400);
        }

        $calender_info = GovtCalendar::getCalenderInfoForPeriod($start_date, $end_date);

        //for each employee in punching as a row, show columns for each day of month

        $empMonPunchings = [];
        for ($i = 1; $i <= $date->daysInMonth; $i++) {

            $d = $date->day($i);
            $d_str = $d->format('Y-m-d');
            $dayinfo = [];

            $employeeToSection =  EmployeeToSection::with('section')->where('employee_id', $employee->id)
                ->duringPeriod($d_str,  $d_str)
                ->first();

                \Log::info('date: ' . $d_str);

          //  \Log::info('employeeToSection: ' . $employeeToSection);

            $dayinfo['sl'] = $i;
            $dayinfo['day'] = 'day' . $i;
            $dayinfo['day_str'] = $d_str;
            $dayinfo['punching_count'] = 0;
            $dayinfo['attendance_trace_fetch_complete'] =  $calender_info['day' . $i]['attendance_trace_fetch_complete'];
            $dayinfo['is_holiday'] =  $calender_info['day' . $i]['holiday'];
            $dayinfo['is_future'] = $d->gt(Carbon::today());
            $dayinfo['is_today'] = $d->isToday();

            if ($seat_ids_of_loggedinuser && $employeeToSection) {
                $dayinfo['logged_in_user_is_controller'] = $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id);
                $dayinfo['logged_in_user_is_section_officer'] =  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id);
            }

            $punching = $punchings->where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();

            if( $punching){
                $dayinfo = [...$dayinfo, ...$punching->toArray()];
            }
            //punching trace might have section null. so get it from employeeToSection
            if($employeeToSection){
                $dayinfo = [...$dayinfo,  'section' => $employeeToSection->section->name ];
            }



            $empMonPunchings[] =  $dayinfo;
        }


        $data_monthly = MonthlyAttendance::forEmployeeInMonth($date, $aadhaarid);


        return response()->json([
            'month' => $date->format('F Y'), // 'January 2021
            'employee'  => $employee,
            'calender_info' => $calender_info ,
            'data_monthly' => $data_monthly,
            'employee_punching' => $empMonPunchings,
            // 'employees_in_view' =>  $employees_in_view->groupBy('aadhaarid'),
        ], 200);
    }


}
