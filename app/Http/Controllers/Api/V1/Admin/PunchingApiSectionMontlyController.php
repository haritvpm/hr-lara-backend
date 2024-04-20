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
        $me = User::with('employee')->find(auth()->id());

        if ($me->employee_id == null) {

            return response()->json([
                'status' => 'No linked employee','month' => $date->format('F Y'),
                'calender_info' => $calender_info,
                'monthlypunchings' => [],], 200);
        }

        $seat_ids_of_loggedinuser = EmployeeToSeat::where('employee_id', $me->employee_id)->get()->pluck('seat_id');

        if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser) == 0) {
            return response()->json([
                'status' => 'No seats in charge','month' => $date->format('F Y'),
                'calender_info' => $calender_info,
                'monthlypunchings' => [],], 200);
        }

        //todo. make this a period
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $start_date,
            $end_date,
            $seat_ids_of_loggedinuser,
            $me
        );
        \Log::info('employees_in_view: ' . $employees_in_view);
        //   $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();
        if (!$employees_in_view || $employees_in_view->count() == 0) {
            return response()->json([
                'status' => 'No employees in view','month' => $date->format('F Y'),
                'calender_info' => $calender_info,
                'monthlypunchings' => [],], 200);
        }
        //get all govtcalender between start data and enddate

       //  $data_monthly = (new PunchingService())->calculateMonthlyAttendance($date_str, $aadhaarids );
        $data3 = [];
        foreach ($employees_in_view as $employee) {

            $item =  $employee;
            $aadhaarid = $employee['aadhaarid'];
            //for each employee in punching as a row, show columns for each day of month
            //{position: 1, name: 'Hydrogen', weight: 1.0079, symbol: 'H'},
            for ($i = 1; $i <= $date->daysInMonth; $i++) {

                $d = $date->day($i);
                $d_str = $d->format('Y-m-d');
                $emp_start_date = Carbon::parse($employee['start_date']);
                $emp_end_date = Carbon::parse($employee['end_date']);

                $dayinfo = [];


                $dayinfo['in_section'] = $emp_start_date <= $d && $emp_end_date >= $d;
                $dayinfo['punching_count'] = 0; //this will be overwritten when punching is got below

                $dayinfo['attendance_trace_fetch_complete'] =  $calender_info['day' . $i]['attendance_trace_fetch_complete'];
                $dayinfo['is_holiday'] =  $calender_info['day' . $i]['holiday'];
                $dayinfo['is_future'] = $d->gt(Carbon::today());
                $dayinfo['is_today'] = $d->isToday();

                $punching = Punching::where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();
                if ($punching) {
                    //copy all properties of $punching to $dayinfo
                    $dayinfo = [...$dayinfo, ...$punching->toArray()];
                } else {
                    //no punching found
                }


                $item['day' . $i] = [...$dayinfo];
            }

            $data3[] = $item;
        }

        return response()->json([
            'month' => $date->format('F Y'), // 'January 2021
            'calender_info' => $calender_info,
            //  'sections_under_charge' => $data->pluck('section_name')->unique(),
            'monthlypunchings' => $data3,
            // 'employees_in_view' =>  $employees_in_view->groupBy('aadhaarid'),
        ], 200);
    }

}
