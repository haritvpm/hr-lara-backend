<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Punching;
use App\Models\GovtCalendar;
use App\Models\AttendanceBook;
use Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\EmployeeService;
use App\Models\MonthlyAttendance;


class PunchingApiSectionMontlyController extends Controller
{

    public function getmonthlypunchings(Request $request)
    {

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now(); //today
        $start_date = $date->startOfMonth()->format('Y-m-d');
        $end_date = $date->endOfMonth()->format('Y-m-d');
        $date_str = $date->format('Y-m-d');

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


        //todo. make this a period
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $start_date,
            $end_date,
            $seat_ids_of_loggedinuser,
            $me
        );
        // \Log::info('employees_in_view: ' . $employees_in_view);

        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        if (!$employees_in_view || $employees_in_view->count() == 0) {
            return response()->json([
                'status' => 'No employees in view', 'month' => $date->format('F Y'),
                'calender_info' => $calender_info,
                'monthlypunchings' => [],
            ], 200);
        }
        //get all govtcalender between start data and enddate

        $data_monthly = MonthlyAttendance::forEmployeesInMonth($date, $aadhaarids);

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
            if ($data_monthly &&  $data_monthly->has($aadhaarid)) {
                $item['total_grace_sec'] = $data_monthly[$aadhaarid]['total_grace_sec'];
                $item['total_extra_sec'] = $data_monthly[$aadhaarid]['total_extra_sec'];
                $item['total_grace_str'] = $data_monthly[$aadhaarid]['total_grace_str'];
                $item['total_extra_str'] = $data_monthly[$aadhaarid]['total_extra_str'];
                $item['cl_taken'] = $data_monthly[$aadhaarid]['cl_taken'];
                $item['total_grace_exceeded300_date'] = $data_monthly[$aadhaarid]['total_grace_exceeded300_date'];
            } else {
                $item['total_grace_sec'] = 0;
                $item['total_extra_sec'] = 0;
                $item['cl_taken'] = 0;
                $item['total_grace_exceeded300_date'] = null;
            }

            $total_grace_exceeded300_date = $item['total_grace_exceeded300_date'] ? Carbon::parse($item['total_grace_exceeded300_date']) : null;

            //for each employee in punching as a row, show columns for each day of month
            //{position: 1, name: 'Hydrogen', weight: 1.0079, symbol: 'H'},

            for ($i = 1; $i <= $date->daysInMonth; $i++) {

                $d = $date->day($i);
                $d_str = $d->format('Y-m-d');
                $emp_start_date = Carbon::parse($employee['start_date']);
                $emp_end_date = Carbon::parse($employee['end_date']);

                $dayinfo = [];

                $dayinfo['in_section'] = $emp_start_date->lessThanOrEqualTo($d) && $emp_end_date->greaterThanOrEqualTo($d);
                $dayinfo['punching_count'] = 0; //this will be overwritten when punching is got below

                $dayinfo['attendance_trace_fetch_complete'] =  $calender_info['day' . $i]['attendance_trace_fetch_complete'];
                $dayinfo['is_holiday'] =  $calender_info['day' . $i]['holiday'];
                $dayinfo['is_future'] = $d->gt(Carbon::today());
                $dayinfo['is_today'] = $d->isToday();


                $punching = Punching::where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();
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

                $item['day' . $i] = [...$dayinfo];
            }

            $data[] = $item;
        }

        $attendancebooks = AttendanceBook::wherein('section_id', $section_ids)->pluck('title')
            ->transform(function ($item) {
                return "/{$item}";
            });

        $sections = [...$sections, ...$attendancebooks->toArray()];

        return response()->json([
            'month' => $date->format('F Y'), // 'January 2021
            'calender_info' => $calender_info,
            'sections' => array_values(array_unique($sections)),
            'monthlypunchings' => $data,
            'employees_in_view' =>  $employees_in_view,
        ], 200);
    }
}
