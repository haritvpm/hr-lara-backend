<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Seat;
use App\Models\User;
use App\Models\Punching;
use Carbon\CarbonPeriod;
use App\Models\GovtCalendar;
use Illuminate\Http\Request;
use App\Models\AttendanceBook;
use App\Models\YearlyAttendance;
use App\Models\MonthlyAttendance;
use App\Services\EmployeeService;
use App\Http\Controllers\Controller;


class PunchingApiSectionMontlyController extends Controller
{

    public function getmonthlypunchings(Request $request)
    {

        $start_time = microtime(true);

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::today(); //today
        $start_date = $date->clone()->startOfMonth()->format('Y-m-d');
        $end_date = $date->clone()->endOfMonth()->format('Y-m-d');
        $date_str = $date->format('Y-m-d');
        $month_mode = config('app.month_mode');

        if($month_mode == 'spark')
        {
            $start_date = $date->clone()->startOfMonth()->addDays(15)->format('Y-m-d');
            $end_date = $date->clone()->addMonth()->startOfMonth()->addDays(14)->format('Y-m-d');
        }

        $calender_info = GovtCalendar::getCalenderInfoForPeriod($start_date, $end_date);

        //get current logged in user's charges
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();
        if ($status != 'success' || count($seat_ids_of_loggedinuser) == 0) {

            return response()->json([
                'status' => $status,
                'month' => $date->format('F Y'),
                'calender_info' => $calender_info,
                'monthlypunchings' => [],
            ], 200);
        }
        $sec_seat_id = Seat::where('slug', 'secretary')->first()?->id ?? -1;
        $loadRouting = !$seat_ids_of_loggedinuser->contains($sec_seat_id); //hack

        //todo. make this a period
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $start_date,
            $end_date,
            $seat_ids_of_loggedinuser,
            $me,
            $loadRouting
        );
        // \Log::info('employees_in_view: ' . $employees_in_view);


        if (!$employees_in_view || $employees_in_view->count() == 0) {
            return response()->json([
                'status' => 'No employees in view', 'month' => $date->format('F Y'),
                'calender_info' => $calender_info,
                'monthlypunchings' => [],
            ], 200);
        }
        //get all govtcalender between start data and enddate
        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();
        //$punchings_of_employees = Punching::with('leave')->wherein('aadhaarid',  $aadhaarids)->whereBetween('date', [$start_date, $end_date])->get();

        $data_monthly = MonthlyAttendance::forEmployeesInMonth($date, $aadhaarids);
        $data_yearly = YearlyAttendance::forEmployeesInYear($date, $aadhaarids);

        $data = [];
        $sections = [];
        $section_ids = [];

        foreach ($employees_in_view as $employee) {

            $item =  $employee;
            $aadhaarid = $employee['aadhaarid'];
            $sections[] = $employee['section_name'];
            $section_ids[] = $employee['section_id'];
            //mapped after fetching. so no need to check if it exists
            $item['start_date'] = $start_date;
            $item['e'] = $end_date;
            if ($data_monthly &&  $data_monthly->has($aadhaarid)) {
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

            if ($data_yearly &&  $data_yearly->has($aadhaarid)) {
                $item['start_with_cl'] = $data_yearly[$aadhaarid]['start_with_cl'] ?? 0;
                $item['cl_marked'] = $data_yearly[$aadhaarid]['cl_marked'] ;
                $item['cl_submitted'] = $data_yearly[$aadhaarid]['cl_submitted'];
                $item['single_punchings'] = $data_yearly[$aadhaarid]['single_punchings'];
                $item['start_with_compen'] = $data_yearly[$aadhaarid]['start_with_compen'] ?? 0;
                $item['compen_marked'] = $data_yearly[$aadhaarid]['compen_marked'] ;
                $item['compen_submitted'] = $data_yearly[$aadhaarid]['compen_submitted'];
                $item['other_leaves_marked'] = $data_yearly[$aadhaarid]['other_leaves_marked'];
            } else {
                $item['cl_marked'] = 0;
                $item['cl_submitted'] = 0;
                $item['single_punchings'] = 0;
                $item['compen_marked'] = 0;
                $item['compen_submitted'] = 0;
                $item['other_leaves_marked'] = 0;
                $item['start_with_compen'] = 0;
                $item['start_with_cl'] = 0;
            }
            $item['grace_left'] = ceil(($item['grace_limit'] - $item['total_grace_sec']/60));
            $item['extraMin'] =  ceil($item['total_extra_sec']/60);


            $total_grace_exceeded300_date = $item['total_grace_exceeded300_date'] ? Carbon::parse($item['total_grace_exceeded300_date']) : null;

            //for each employee in punching as a row, show columns for each day of month
            //{position: 1, name: 'Hydrogen', weight: 1.0079, symbol: 'H'},

            $punchings_of_employee = Punching::with('leave')->where('aadhaarid', $aadhaarid)->whereBetween('date', [$start_date, $end_date])->get();

            $period = CarbonPeriod::create(Carbon::parse($start_date), Carbon::parse($end_date));
            $i=1;
            foreach ($period as $d) {

                $d_str = $d->format('Y-m-d');
                $emp_start_date = Carbon::parse($employee['start_date'])->startOfDay();
                //if end_date is not set, then set it to end of year
                $emp_end_date = $employee['end_date'] ? Carbon::parse($employee['end_date'])->endOfDay() : $emp_start_date->clone()->endOfYear();

                $dayinfo = [];

                $dayinfo['in_section'] = $emp_start_date->lessThanOrEqualTo($d) && $emp_end_date->greaterThanOrEqualTo($d);
                $dayinfo['punching_count'] = 0; //this will be overwritten when punching is got below

                $dayinfo['attendance_trace_fetch_complete'] =  $calender_info['day' . $i]['attendance_trace_fetch_complete'];
                $dayinfo['is_holiday'] =  $calender_info['day' . $i]['holiday'];
                $dayinfo['is_future'] = $d->gt(Carbon::now());
                $dayinfo['is_today'] = $d->isToday();
                $dayinfo['date'] = $d_str;

                //$punching = Punching::with('leave')->where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();
                $punching = $punchings_of_employee->where('date', $d_str)->first();
                //$punching = $punchings_of_employees->where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();
                if ($punching) {
                    //copy all properties of $punching to $dayinfo
                    $dayinfo = [
                        ...$dayinfo, ...$punching->toArray(),
                        'in_time' => substr($punching->in_datetime, 10, -3),
                        'out_time' => substr($punching->out_datetime, 10, -3),
                    ];

                    if ($total_grace_exceeded300_date && $d->gte($total_grace_exceeded300_date) && $punching->grace_sec > 60) {
                        $dayinfo['grace_exceeded300_and_today_has_grace'] = true;
                    } else {
                        $dayinfo['grace_exceeded300_and_today_has_grace'] = false;
                    }
                } else {
                    //no punching found
                    //set name, designation,
                    $dayinfo = [...$dayinfo, 'name' => $employee['name'], 'aadhaarid' => $aadhaarid];
                }
                $dayinfo['section'] = $employee['section_name'];;

                //sometimes, if there is only leave in punching, name, desig etc will be overwritten
                if($dayinfo['name']==null){
                    $dayinfo['name'] = $employee['name'];
                    $dayinfo['designation'] = $employee['designation'];
                    // if(!$dayinfo['grace_str']) $dayinfo['grace_str'] = '0';
                    // if(!$dayinfo['extra_str']) $dayinfo['extra_str'] = '0';
                }

                $item['day' . $i] = [...$dayinfo];
                $i++;
            }

            $data[] = $item;
        }

        $attendancebooks = AttendanceBook::wherein('section_id', $section_ids)->pluck('title')
            ->transform(function ($item) {
                return "/{$item}";
            });

        $sections = [...$sections, ...$attendancebooks->toArray()];


        \Log::info('time taken: ' . (microtime(true) - $start_time));

        return response()->json([
            'month' => Carbon::parse($start_date)->format('F Y'), // 'January 2021
            'calender_info' => $calender_info,
            'sections' => array_values(array_unique($sections)),
            'monthlypunchings' => $data,
            'employees_in_view' =>  $employees_in_view,
        ], 200);
    }
}
