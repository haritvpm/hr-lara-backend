<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Leaf;
use App\Models\User;
use App\Models\Section;
use App\Models\Employee;
use App\Models\Punching;
use App\Models\GovtCalendar;
use Illuminate\Http\Request;
use App\Models\PunchingTrace;
use App\Models\EmployeeToSeat;
use App\Models\YearlyAttendance;
use App\Models\EmployeeToSection;
use App\Models\MonthlyAttendance;
use App\Services\EmployeeService;
use App\Http\Controllers\Controller;
use App\Services\PunchingCalcService;
use App\Http\Requests\StorePunchingRequest;
use App\Http\Requests\UpdatePunchingRequest;
use App\Http\Resources\Admin\PunchingResource;
use Symfony\Component\HttpFoundation\Response;

class PunchingApiEmployeeMontlyController extends Controller
{
    public function getemployeeMonthlyPunchings(Request $request)
    {
       // \Log::info('getemployeeMonthlyPunchings: ' . $request);

        $aadhaarid = $request->aadhaarid;
        $date_str = $request->query('date', Carbon::now()->format('Y-m-d'));
      //  \Log::info('getemployeeMonthlyPunchings: ' . $date_str);
        $date = Carbon::createFromFormat('Y-m-d', $date_str);
        $start_date = $date->clone()->startOfMonth()->format('Y-m-d');
        $end_date = $date->clone()->endOfMonth()->format('Y-m-d');
        //$date_str = $date->format('Y-m-d');
        $employee = Employee::with('designation')->where('aadhaarid', $aadhaarid)->first();
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
        // $emp_start_date = Carbon::parse($employee['start_date'])->startOfDay();
        // $emp_end_date = $employee['end_date'] ? Carbon::parse($employee['end_date'])->endOfDay() : $emp_start_date->clone()->endOfYear();
        $data_monthly = MonthlyAttendance::forEmployeeInMonth($date, $aadhaarid);
        $data_yearly = YearlyAttendance::forEmployeeInYear($date, $aadhaarid);
        $total_grace_exceeded300_date = null;
        if ($data_monthly ) {
            $total_grace_exceeded300_date = $data_monthly['total_grace_exceeded300_date'];
        }

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
            $dayinfo['is_future'] = $d->gt(Carbon::now()) && !$d->isToday() ;
            $dayinfo['is_today'] = $d->isToday();

           // $dayinfo['in_section'] = $emp_start_date->lessThanOrEqualTo($d) && $emp_end_date->greaterThanOrEqualTo($d);

            if ($seat_ids_of_loggedinuser && $employeeToSection) {
                $dayinfo['logged_in_user_is_controller'] = $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id);
                $dayinfo['logged_in_user_is_section_officer'] =  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id);
            }
            // if this is self, no need to check for section
            $dayinfo['in_section'] = $employeeToSection != null || $me->employee->aadhaarid == $aadhaarid;

            $punching = $punchings->where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();

            if( $punching){
                $dayinfo = [...$dayinfo, ...$punching->toArray(),
                'in_time' => substr($punching->in_datetime, 10, -3),
                'out_time' => substr($punching->out_datetime, 10, -3),];

                $total_grace_exceeded300_date =  $total_grace_exceeded300_date ? Carbon::parse( $total_grace_exceeded300_date ) : null;
                if ($total_grace_exceeded300_date && $date->gte($total_grace_exceeded300_date) && $punching?->grace_sec > 60) {
                    $dayinfo['grace_exceeded300_and_today_has_grace'] = true;
                } else {
                    $dayinfo['grace_exceeded300_and_today_has_grace'] = false;
                }

            }
            //punching trace might have section null. so get it from employeeToSection
            if($employeeToSection){
                $dayinfo = [...$dayinfo,  'section' => $employeeToSection->section->name ];
            }



            $empMonPunchings[] =  $dayinfo;
        }




        $employee['designation_now'] = $employee->designation->first()->designation->designation;

        $emp_leaves = Leaf::where('aadhaarid', $aadhaarid)
        ->orderBy('creation_date', 'desc')
        ->get()->transform(function ($item) {

            $date_start = Carbon::parse($item->start_date);
            $date_to = Carbon::parse($item->end_date);
            $diff = $date_start->diffInDays($date_to)+1;

            return [
                ...$item->toArray(), 'day_count' => $diff,
            ];
        });

        return response()->json([
            'month' => $date->format('F Y'), // 'January 2021
            'employee'  => $employee,
            'calender_info' => $calender_info ,
            'data_monthly' => $data_monthly,
            'data_yearly' => $data_yearly,
            'employee_punching' => $empMonPunchings,
             'emp_leaves' =>  $emp_leaves,
        ], 200);
    }
    public function saveEmployeeHint(Request $request)
    {
\Log::info('saveEmployeeHint: ' . $request);
\Log::info('date: ' . $request->date);

$aadhaarid = $request->aadhaarid;
        $hint = $request->hint;
        $remarks = $request->remarks;
        //check if logged in user is controller for this employee
        [$me , $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();
        //get section of employee
        [$section, $status, $code] =  EmployeeService::getSectionOfEmployeeOnDate( $aadhaarid, $request->date);
        if(!$section || $status != 'success'){
            return response()->json(['status' => $status], $code);
        }

        //get this section's controller and reporting officer
        $loggedInUserIsController = $seat_ids_of_loggedinuser->contains($section->seat_of_controlling_officer_id);
        $loggedInUserIsSectionOfficer = $seat_ids_of_loggedinuser->contains($section->seat_of_reporting_officer_id);

        if (!$loggedInUserIsController && !$loggedInUserIsSectionOfficer) {
            return response()->json(['status' => 'Not authorized'], 400);
        }

        //since this might be first time, insert if not exists
        $punching = Punching::updateOrCreate(
            ['aadhaarid' => $aadhaarid, 'date' => $request->date],
            [
                'hint' => $hint,
                'remarks' => $remarks,
                'finalized_by_controller' => $loggedInUserIsController,
            ]
        );

        //recalculate daily and monthly
        $punchingService = new PunchingCalcService();
        $punchingService->calculate($request->date, [$aadhaarid]);

        return response()->json(['status' => 'success'], 200);

    }


}
