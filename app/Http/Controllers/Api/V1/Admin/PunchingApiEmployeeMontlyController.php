<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Auth;
use Gate;
use Carbon\Carbon;
use App\Models\Leaf;
use App\Models\User;
use App\Models\Section;
use App\Models\Employee;
use App\Models\Punching;
use Carbon\CarbonPeriod;
use App\Models\GovtCalendar;
use Illuminate\Http\Request;
use App\Models\CompenGranted;
use App\Models\EmployeeToSeat;
use App\Models\YearlyAttendance;
use App\Models\AttendanceRouting;
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
        \Log::info('getemployeeMonthlyPunchings: ' . $date_str);
        $date = Carbon::createFromFormat('Y-m-d', $date_str);


        $start_date = $date->clone()->startOfMonth()->format('Y-m-d');
        $end_date = $date->clone()->endOfMonth()->format('Y-m-d');

        $month_mode = config('app.month_mode');

        if ($month_mode == 'spark') {
            $start_date = $date->clone()->startOfMonth()->addDays(15)->format('Y-m-d');
            $end_date = $date->clone()->addMonth()->startOfMonth()->addDays(14)->format('Y-m-d');
        }


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


        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();
        $isSecretary = Auth::user()->hasRole('secretary');

        if (Auth::user()->canDo('can_view_all_section_attendance')) {

        } else {

            if ($status != 'success') {
                return response()->json(['status' => $status, 'message' => 'No seats mapped'], 400);
            }
        }

        $calender_info = GovtCalendar::getCalenderInfoForPeriod($start_date, $end_date);

        //for each employee in punching as a row, show columns for each day of month
        // $emp_start_date = Carbon::parse($employee['start_date'])->startOfDay();
        // $emp_end_date = $employee['end_date'] ? Carbon::parse($employee['end_date'])->endOfDay() : $emp_start_date->clone()->endOfYear();
        $data_monthly = MonthlyAttendance::forEmployeeInMonth($date, $aadhaarid);
        $data_yearly = YearlyAttendance::forEmployeeInYear($date, $aadhaarid);
        $total_grace_exceeded300_date = null;
        if ($data_monthly) {
            $total_grace_exceeded300_date = $data_monthly['total_grace_exceeded300_date'];
        }

        $empMonPunchings = [];
        $period = CarbonPeriod::create(Carbon::parse($start_date), Carbon::parse($end_date));
        $i = 1;
        foreach ($period as $d) {

            $d_str = $d->format('Y-m-d');
            $dayinfo = [];

            $employeeToSection =  EmployeeToSection::with('section')->where('employee_id', $employee->id)
                ->duringPeriod($d_str,  $d_str)
                ->first();

           // \Log::info('foreach date: ' . $d_str);

            //  \Log::info('employeeToSection: ' . $employeeToSection);

            $dayinfo['sl'] = $i;
            $dayinfo['day'] = 'day' . $i;
            $dayinfo['day_str'] = $d_str;
            $dayinfo['punching_count'] = 0;
            $dayinfo['attendance_trace_fetch_complete'] =  $calender_info['day' . $i]['attendance_trace_fetch_complete'];
            $dayinfo['is_holiday'] =  $calender_info['day' . $i]['holiday'];
            $dayinfo['is_future'] = $d->gt(Carbon::now()) && !$d->isToday();
            $dayinfo['is_today'] = $d->isToday();

            // $dayinfo['in_section'] = $emp_start_date->lessThanOrEqualTo($d) && $emp_end_date->greaterThanOrEqualTo($d);

            if ($seat_ids_of_loggedinuser && $employeeToSection) {

                $soIstheEmployee = $aadhaarid == $me?->employee->aadhaarid; //SO is also mapped to the section as employee

                $dayinfo['logged_in_user_is_controller'] = $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id);
                $dayinfo['logged_in_user_is_section_officer'] =  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id);

                $dayinfo['logged_in_user_is_superior_officer'] =   $isSecretary ||
                    $dayinfo['logged_in_user_is_controller'] ||
                    ($dayinfo['logged_in_user_is_section_officer'] && !$soIstheEmployee) ||
                    AttendanceRouting::recurseFindIfSuperiorOfficer($seat_ids_of_loggedinuser, $employeeToSection->section->seat_of_controlling_officer_id);
            }
            // if this is self, no need to check for section
            $dayinfo['in_section'] = $employeeToSection != null || $me->employee->aadhaarid == $aadhaarid;

            $punching = $punchings->where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();

            if ($punching) {
                $dayinfo = [
                    ...$dayinfo, ...$punching->toArray(),
                    'in_time' => substr($punching->in_datetime, 10, -3),
                    'out_time' => substr($punching->out_datetime, 10, -3),
                ];

                $total_grace_exceeded300_date =  $total_grace_exceeded300_date ? Carbon::parse($total_grace_exceeded300_date) : null;
                //\Log::info('total_grace_exceeded300_date: ' . $total_grace_exceeded300_date->format('Y-m-d'));
                //\Log::info('total_grace_exceeded300_datedate: ' . $date->format('Y-m-d'));

                if ($total_grace_exceeded300_date && $d->gte($total_grace_exceeded300_date) && $punching?->grace_sec > 60) {
                    $dayinfo['grace_exceeded300_and_today_has_grace'] = true;
                } else {
                    $dayinfo['grace_exceeded300_and_today_has_grace'] = false;
                }
            }
            //punching trace might have section null. so get it from employeeToSection
            if ($employeeToSection) {
                $dayinfo = [
                    ...$dayinfo,  'section' => $employeeToSection->section->name,
                    'name' => $employeeToSection->employee->name,
                ];
            }


            $i = $i + 1;
            $empMonPunchings[] =  $dayinfo;
        }




        $employee['designation_now'] = $employee->designation->first()->designation->designation;

      //  $emp_leaves = Leaf::getEmployeeLeaves($aadhaarid);

        $now_str = Carbon::now()->format('Y-m-d');
        $employeeToSectionNow =  EmployeeToSection::with('section')->where('employee_id', $employee->id)
            ->duringPeriod($now_str,  $now_str)
            ->first();
        $logged_in_user_is_controller = false;

        if ($seat_ids_of_loggedinuser && $employeeToSectionNow) {
            $logged_in_user_is_controller  = $seat_ids_of_loggedinuser->contains($employeeToSectionNow?->section?->seat_of_controlling_officer_id);
           // $dayinfo['logged_in_user_is_section_officer'] =  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id);
        }

        return response()->json([
            'month' => Carbon::parse($start_date)->format('F Y'), // 'January 2021
            'employee'  => $employee,
            'calender_info' => $calender_info,
            'data_monthly' => $data_monthly,
            'data_yearly' => $data_yearly,
            'employee_punching' => $empMonPunchings,
          //  'emp_leaves' =>  $emp_leaves,
            'logged_in_user_is_controller' => $logged_in_user_is_controller,
        ], 200);
    }
    public function saveEmployeeHint(Request $request)
    {
        \Log::info('saveEmployeeHint: ' . $request);
        //\Log::info('date: ' . $request->date);

        $aadhaarid = $request->aadhaarid;
        $hint = $request->hint;
        $remarks = $request->remarks;
        $isSinglePunch= $request?->isSinglePunch ?? false;
        $single_punch_type =  $isSinglePunch ? $request?->single_punch_type : null;
        $regulariseSinglePunch = $request?->regulariseSinglePunch ?? false;
       

        //check if logged in user is controller for this employee
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();
        //get section of employee
        [$section, $status, $code] =  EmployeeService::getSectionOfEmployeeOnDate($aadhaarid, $request->date);
        if (!$section || $status != 'success') {
            return response()->json(['status' => $status], $code);
        }

        //get this section's controller and reporting officer
        $loggedInUserIsController = $seat_ids_of_loggedinuser->contains($section->seat_of_controlling_officer_id);
        $loggedInUserIsSectionOfficer = $seat_ids_of_loggedinuser->contains($section->seat_of_reporting_officer_id);
        $loggedInUserIsSuperiorOfficer = AttendanceRouting::recurseFindIfSuperiorOfficer(
                                            $seat_ids_of_loggedinuser, $section->seat_of_controlling_officer_id);

        if (!$loggedInUserIsController && !$loggedInUserIsSectionOfficer && !$loggedInUserIsSuperiorOfficer) {
            return response()->json(['status' => 'Not authorized'], 403);
        }

        $missingDateTime = $request->missingDateTime ?? null;
        if ($missingDateTime) {
            $c_missingDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $missingDateTime);

            //make sure this is after punchin if this is punchout
            if($single_punch_type == 'out' || $single_punch_type == 'in'){

                $punching = Punching::where('aadhaarid', $aadhaarid)->where('date', $request->date)->first();
                if ($single_punch_type == 'in') {
                    if ($punching && Carbon::parse($punching->in_datetime)->gte($c_missingDateTime)) {
                        return response()->json(['message' => 'Punchout time should be after punchin time'], 400);
                    }
                } else if ($single_punch_type == 'out') {

                    if ($punching && Carbon::parse($punching->out_datetime)->lte($c_missingDateTime)) {
                        return response()->json(['message' => 'Punchin time should be before punchout time'], 400);
                    }
                }
            }
        }
        
        if($regulariseSinglePunch ){
            $hint = 'clear'; //remove unauthorized hint
        }

        //since this might be first time, insert if not exists
        $punching = Punching::updateOrCreate(
            ['aadhaarid' => $aadhaarid, 'date' => $request->date],
            [
                'hint' => $hint,
                'remarks' => $remarks,
                'finalized_by_controller' => $loggedInUserIsController,
                'single_punch_type' => $single_punch_type,
                'single_punch_regularised_by' => $regulariseSinglePunch ? $me->employee->aadhaarid : null,
                'controller_set_punch_in' => $single_punch_type == 'out' ? $missingDateTime : null,
                'controller_set_punch_out' => $single_punch_type == 'in' ? $missingDateTime : null,
            ]
        );

        //recalculate daily and monthly
        $punchingService = new PunchingCalcService();
        $punchingService->calculate($request->date, [$aadhaarid]);

        return response()->json(['status' => 'success'], 200);
    }
    public function getemployeeYearlyPunchingsMontwise(Request $request)
    {
        $aadhaarid = $request->aadhaarid;
        $date_str = $request->query('date', Carbon::now()->format('Y-m-d'));
        //  \Log::info('getemployeeMonthlyPunchings: ' . $date_str);
        $date = Carbon::createFromFormat('Y-m-d', $date_str);
        $start_date = $date->clone()->startOfYear();
        $end_date = $date->clone()->endOfYear();

       //get all start of month dates in the year of this date
        $start_date = $date->clone()->startOfYear();
        $end_date = $date->clone()->endOfYear()->startOfMonth();
        $period = CarbonPeriod::create($start_date->format('Y-m-d'), '1 month', $end_date->format('Y-m-d'));

        $dates = [];
        foreach ($period as $d) {
            $dates[] = $d->format('Y-m-d');
        }

        $data = MonthlyAttendance::wherein('month', $dates)
            ->where('aadhaarid', $aadhaarid)
            ->orderBy('month', 'desc')
            ->get();

        return response()->json([
            'year' => $date->format('Y'), // '2021

            'allmonthdata' => $data,

        ], 200);
    }
}
