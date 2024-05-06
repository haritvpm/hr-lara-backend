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
use App\Services\PunchingCalcService;
use App\Services\EmployeeService;
use App\Models\MonthlyAttendance;
use App\Models\YearlyAttendance;
use App\Models\Employee;

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
                $dayinfo = [...$dayinfo, ...$punching->toArray()];
            }
            //punching trace might have section null. so get it from employeeToSection
            if($employeeToSection){
                $dayinfo = [...$dayinfo,  'section' => $employeeToSection->section->name ];
            }



            $empMonPunchings[] =  $dayinfo;
        }


        $data_monthly = MonthlyAttendance::forEmployeeInMonth($date, $aadhaarid);
        $data_yearly = YearlyAttendance::forEmployeeInYear($date, $aadhaarid);

        $employee['designation_now'] = $employee->designation->first()->designation->designation;
        
        return response()->json([
            'month' => $date->format('F Y'), // 'January 2021
            'employee'  => $employee,
            'calender_info' => $calender_info ,
            'data_monthly' => $data_monthly,
            'data_yearly' => $data_yearly,
            'employee_punching' => $empMonPunchings,
            // 'employees_in_view' =>  $employees_in_view->groupBy('aadhaarid'),
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
