<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Auth;
use App\Models\GovtCalendar;
use App\Models\Punching;
use App\Models\PunchingTrace;
use App\Models\Employee;
use App\Models\YearlyAttendance;
use App\Services\EmployeeService;
use App\Models\MonthlyAttendance;
use App\Models\OfficeTime;

class PunchingCalcService
{
    public function getPunchingTracesForDay($date,  $aadhaar_ids)
    {
        $query = PunchingTrace::where('att_date', $date)
            ->where('auth_status', 'Y');
        $query->when($aadhaar_ids, function ($q) use ($aadhaar_ids) {
            return $q->wherein('aadhaarid', $aadhaar_ids);
        });
        return $query->orderBy('created_date', 'asc')->get();
    }
    public function getPunchingTracesForPeriod($start_date,  $end_date, $aadhaar_ids)
    {
        $query = PunchingTrace::whereBetween('att_date', [$start_date, $end_date])
            ->where('auth_status', 'Y');
        $query->when($aadhaar_ids, function ($q) use ($aadhaar_ids) {
            return $q->wherein('aadhaarid', $aadhaar_ids);
        });
        return $query->orderBy('created_date', 'asc')->get();
    }
    public function getAadhaaridsOfPunchingTracesForPeriod($start_date,  $end_date)
    {
        $query = PunchingTrace::whereBetween('att_date', [$start_date, $end_date])
            ->where('auth_status', 'Y');
        return $query->orderBy('created_date', 'asc')->get(['aadhaarid']);
    }

    public function getPunchingsForDay($date,  $aadhaar_ids)
    {
        return Punching::where('date', $date)
            ->wherein('aadhaarid', $aadhaar_ids)->get();
    }

    public function calculate($date, $aadhaar_ids = null)
    {
        //grab punching trace for the employees.
        $all_punchingtraces =  $this->getPunchingTracesForDay($date,  $aadhaar_ids);

        $allemp_punchingtraces_grouped =  $all_punchingtraces->groupBy('aadhaarid');

        $aadhaar_to_empIds = [];
        $emp_ids = [];


        if ($aadhaar_ids == null) {
            $aadhaar_ids  = $all_punchingtraces->pluck('aadhaarid');
        }
        // $emps = Employee::where('status', 'active')->where('has_punching', 1)->get();

        $emps = Employee::wherein('aadhaarid', $aadhaar_ids)->get();
        $aadhaar_to_empIds = $emps->pluck('id', 'aadhaarid');
        $emp_ids = $emps->pluck('id');

        //we need Punching if it exists, to get hints like half day leave
        // $allemp_punchings_existing  =  $this->getPunchingsForDay($date,  $aadhaar_ids)->groupBy('aadhaarid');

        $time_groups  = OfficeTime::get()->mapWithKeys(function ($item, int $key) {
            return [$item['id'] => $item];
        });

        $employee_section_maps =  EmployeeService::getDesignationOfEmployeesOnDate($date,  $emp_ids);
        //for each empl, calculate

        $calender = GovtCalendar::where('date', $date)->first();

        $data = collect([]);

        foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
            $emp_new_punching_data = [];
            $emp_new_punching_data['date'] = $date; //->format('Y-m-d');
            $emp_new_punching_data['aadhaarid'] = $aadhaarid;
            $emp_new_punching_data['employee_id'] = $employee_id;

            //this employee might not have been mapped to a section
            if ($employee_section_maps->has($aadhaarid)) {
                $emp_new_punching_data['designation'] = $employee_section_maps[$aadhaarid]['designation'];
                // $emp_new_punching_data['section'] = $employee_section_maps[$aadhaarid]['section'];
                $emp_new_punching_data['name'] = $employee_section_maps[$aadhaarid]['name'];
                $time_group_id = $employee_section_maps[$aadhaarid]['time_group_id'] ?? 1;
                //only call this if we have an employee section map
                //use upsert insetad of updateorcreate inside calculateforemployee

                $time_group = $time_groups[$time_group_id];


                $data[] = $this->calculateEmployeeDaily(
                    $date,
                    $aadhaarid,
                    $employee_id,
                    $allemp_punchingtraces_grouped,
                    $emp_new_punching_data,
                  //  $allemp_punchings_existing,
                    $time_group,
                    $calender
                );
            }
        }

        Punching::upsert(
            $data->all(),
            uniqueBy: ['date', 'aadhaarid'],
            update: [
                'employee_id',  'name', 'designation',  'section',
                'punching_count',  'punchin_trace_id',
                'in_datetime',   'punchout_trace_id',
                'out_datetime',   'duration_sec',
                'duration_str',
                'grace_sec',   'extra_sec',
                'grace_str',   'extra_str',
                'grace_total_exceeded_one_hour', 'computer_hint', 'hint'
            ]
        );

        // foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
        //     PunchingTrace::where('att_date', $date)
        //         ->where('auth_status', 'Y');
        //         ->where('aadhaarid', $aadhaarid)
        //         ->update( [ 'punching_id' =>  ] );

        //  }

        //calculate sum of extra and grace seconds for this month and update monthlyattendance table
        $data = $this->calculateMonthlyAttendance($date, $aadhaar_ids, $emp_ids, $aadhaar_to_empIds);
        $this->calculateYearlyAttendance($date, $aadhaar_ids, $emp_ids, $aadhaar_to_empIds);

        $calender->update(['calc_count' => $calender->calc_count ?  $calender->calc_count + 1 : 1]);

        //return $data;
    }

    public function calculateEmployeeDaily(
        $date,
        $aadhaarid,
        $employee_id,
        $allemp_punchingtraces_grouped,
        $emp_new_punching_data,
     //   $allemp_punchings_existing,
        $time_group,
        $calender
    ) {

        $punchingtraces =  $allemp_punchingtraces_grouped->has($aadhaarid) ?
            $allemp_punchingtraces_grouped->get($aadhaarid) : null;

        $punch_count =  $punchingtraces ? count($punchingtraces) : 0;



        $emp_new_punching_data['punching_count'] = $punch_count;

        // $punching_existing = $allemp_punchings_existing->has($aadhaarid) ?
        //     $allemp_punchings_existing->get($aadhaarid) : null;

        $punching_existing = Punching::where('date', $date)
            ->where('aadhaarid', $aadhaarid)
            ->first();

        $hint = $punching_existing?->hint ?? null;

        //    \Log::info('$punching_existing hint:' . $punching_existing['hint']);
            \Log::info('hint:' . $hint);

        $c_punch_in = null;
        $c_punch_out = null;
        $emp_new_punching_data['punchin_trace_id'] = null;
        $emp_new_punching_data['in_datetime'] = null;
        $emp_new_punching_data['punchout_trace_id'] = null;
        $emp_new_punching_data['out_datetime'] = null;
        $emp_new_punching_data['duration_sec'] = 0;
        $emp_new_punching_data['duration_str'] = '';
        $emp_new_punching_data['grace_sec'] = 0;
        $emp_new_punching_data['grace_str'] = '';
        $emp_new_punching_data['extra_sec'] = 0;
        $emp_new_punching_data['extra_str'] = '';
        $emp_new_punching_data['grace_total_exceeded_one_hour'] = 0;
        $emp_new_punching_data['computer_hint'] = null;
        $emp_new_punching_data['hint'] = $hint;
        if ($punch_count) {
        }
        if ($punch_count  >= 1) {
            //TODO is it punch in or out ? has to be set by under
            //todo, check hint to set this as punchin or out. now set as in
            $punch = $punchingtraces[0];
            $emp_new_punching_data['punchin_trace_id'] = $punch['id'];
            $c_punch_in = Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $emp_new_punching_data['in_datetime'] =  $c_punch_in->toDateTimeString();
        }
        if ($punch_count >= 2) {

            $punch = $punchingtraces[$punch_count - 1];
            $emp_new_punching_data['punchout_trace_id'] = $punch['id'];
            $c_punch_out =  Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $emp_new_punching_data['out_datetime'] =  $c_punch_out->toDateTimeString();
        }

        $duration_sec = 0;
        $duration_str = '';
        $flexi_15minutes = $time_group['flexi_minutes'] ?? 15;

        if ($c_punch_in && $c_punch_out) {
            //get employee time group. now assume normal
            //

            //use today's date. imagine legislation punching out next day. our flexiend is based on today
            $duration_sec = $c_punch_in->diffInSeconds($c_punch_out);
            $emp_new_punching_data['duration_sec'] = $duration_sec;
            $emp_new_punching_data['duration_str'] = floor($duration_sec / 3600) . gmdate(":i:s", $duration_sec % 3600);


            $normal_fn_in = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['fn_from']); //10.15
            $normal_fn_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['fn_to']); //1.15

            $normal_an_in = $normal_an_out = null;
            if ($time_group['groupname'] != 'parttime') {
                $normal_an_in = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['an_from']); //2.00pm
                $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['an_to']); //5.15pm
            } else {
                $normal_an_out = $normal_fn_out;
            }


            $c_flexi_10am = $normal_fn_in->clone()->subMinutes($flexi_15minutes);
            $c_flexi_530pm = $normal_an_out->clone()->addMinutes($flexi_15minutes);
            $c_flexi_1030am = $normal_fn_in->clone()->addMinutes($flexi_15minutes);
            $c_flexi_5pm = $normal_an_out->clone()->subMinutes($flexi_15minutes);

            $max_grace_seconds = 3600;
            //todo ooffice ends at noon or 3.00 pm


            $office_ends_at_300pm = 0;
            $office_ends_at_noon = 0;
            $can_take_casual_fn = $can_take_casual_an = true;
            if ($time_group['groupname'] != 'parttime') { //theirs end at 11 am
                if ($office_ends_at_300pm) {
                    $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '15:00:00'); //
                    //  $max_grace_seconds = 1800; // ?
                    $can_take_casual_fn = false;
                } else
                if ($office_ends_at_noon) {
                    $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '13:15:00'); //
                    //  $max_grace_seconds = 1800; // ?
                    $can_take_casual_fn = $can_take_casual_an = false;
                }
            } else {
                $can_take_casual_an = $can_take_casual_fn = false;
            }

            $duration_seconds_needed =  $normal_fn_in->diffInSeconds($normal_an_out);



            // \Log::info( 'duration_seconds_needed:'. $duration_seconds_needed);

            $isFullDay = true;

            [$computer_hint, $grace_total_exceeded_one_hour] = $this->setHintIfPunchMoreThanOneHourLate(
                $c_punch_in,
                $c_punch_out,
                $duration_seconds_needed,
                $c_flexi_10am,
                $c_flexi_1030am,
                $c_flexi_530pm,
                $c_flexi_5pm,
                $can_take_casual_fn,
                $can_take_casual_an
            );

            $isHoliday = $calender->govtholidaystatus || $hint == 'RH';

            if ($isHoliday) {
                $computer_hint = '';
                $grace_total_exceeded_one_hour = 0;
            }

            //TODO check if casual 20 limit has reached. if so set leave

            $emp_new_punching_data['computer_hint'] = $computer_hint;

            if( !$hint){ //if hint exists, no need to use computer hint
              //  $emp_new_punching_data['hint'] = $computer_hint; //set both same for now. SO can change hint
            }
            $emp_new_punching_data['grace_total_exceeded_one_hour'] = $grace_total_exceeded_one_hour;

            //if real hint set by so exists, use that instead of computer hint
            //adjust punching times  based on computer hint or hint. so for example, only half day is calculated
            //if ($grace_total_exceeded_one_hour > 1800)
            {
                if ($can_take_casual_fn && /*$computer_hint == 'casual_fn') ||*/ $hint == 'casual_fn') {

                    $c_flexi_10am = $normal_an_in->clone()->subMinutes($flexi_15minutes); //2pm -15
                    //    $c_flexi_1030am = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '14:15:00');  //2pm +15
                    $duration_seconds_needed =  $normal_an_in->diffInSeconds($normal_an_out); //3.15 hour

                    $isFullDay = false;
                    //   $max_grace_seconds = 1800;
                } else
                if ($can_take_casual_an && /*$computer_hint == 'casual_an') ||*/ $hint == 'casual_an') {
                    $c_flexi_530pm = $normal_fn_out->clone()->addMinutes($flexi_15minutes); //1.15 +15
                    //  $c_flexi_5pm = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '13:00:00'); //1.15 - 15
                    //$duration_seconds_needed = 3 * 3600;
                    $duration_seconds_needed =  $normal_fn_in->diffInSeconds($normal_fn_out); //3.00 hour
                    $isFullDay = false;
                    //   $max_grace_seconds = 1800;
                } else if ($computer_hint == 'casual') {
                    //punched, but not enough time worked or office ends and 3 pm/12pm situations

                }
            }

            //if punches in before 10 am or punches out after 5.30, dont take that, use 10am and 5.30
            $c_start = $c_punch_in->lessThan($c_flexi_10am)  ? $c_flexi_10am : $c_punch_in;
            $c_end = $c_punch_out->greaterThan($c_flexi_530pm)  ? $c_flexi_530pm : $c_punch_out;

            //if like from 6 to 9 am, ''casual' will be set by setHintIfPunchMoreThanOneHourLate
    
            
            $isFullDayleave = $hint && $hint != 'casual_an' && $hint != 'casual_fn' && $hint != 'clear';
            $isSinglePunching = $hint == 'single_punch';


            if (!$isHoliday && !$isFullDayleave &&  !$isSinglePunching) //if hint exists, no need to use computer hint for else
            {
                //calculate grace
                $worked_seconds_flexi = $c_start->diffInSeconds($c_end);

                if ($worked_seconds_flexi < $duration_seconds_needed) { //worked less
                    $grace_sec = (($duration_seconds_needed - $worked_seconds_flexi) / 60) * 60; //ignore extra seconds
                    $emp_new_punching_data['grace_sec'] =  $grace_sec;
                    $emp_new_punching_data['grace_str'] =  (int)($grace_sec / 60);
                }

                if ($duration_sec > $duration_seconds_needed) {

                    $extra_sec = $duration_sec - $duration_seconds_needed;

                    $emp_new_punching_data['extra_sec'] = $extra_sec;
                    $emp_new_punching_data['extra_str'] = (int)($extra_sec / 60);
                }
            } else if($isHoliday ) { //if holiday, let them get compen directly
                //punched, but not enough time worked or office ends and 3 pm/12pm situations
                //set grace as 0. but allow extra time as whole day's time
              //  $extra_sec = $duration_sec;
              //  $emp_new_punching_data['extra_sec'] = $extra_sec;
              //  $emp_new_punching_data['extra_str'] = (int)($extra_sec / 60);
            }
        }
        // \Log::info($emp_new_punching_data);

        return $emp_new_punching_data;


        //extra time
    }

    public function setHintIfPunchMoreThanOneHourLate(
        $c_punch_in,
        $c_punch_out,
        $duration_seconds_needed,
        $c_flexi_10am,
        $c_flexi_1030am,
        $c_flexi_530pm,
        $c_flexi_5pm,
        $can_take_casual_fn,
        $can_take_casual_an
    ) {

        //this function assumes that the employee has punched in and out

        $computer_hint = null;
        $grace_total_exceeded_one_hour = 0;

        //check if punching is from 7 am to 10 am or from 6 pm to 11 pm. that is it should overlap with office times
        if ($c_punch_in->greaterThan($c_flexi_5pm) || $c_punch_out->lessThan($c_flexi_1030am)) {
            $computer_hint = 'casual';
            return [$computer_hint, $grace_total_exceeded_one_hour];
        }


        $c_start = $c_punch_in->lessThan($c_flexi_10am)  ? $c_flexi_10am : $c_punch_in;
        $c_end = $c_punch_out->greaterThan($c_flexi_530pm)  ? $c_flexi_530pm : $c_punch_out;

        $worked_seconds_flexi = $c_start->diffInSeconds($c_end);

        if ($duration_seconds_needed > $worked_seconds_flexi && $worked_seconds_flexi >= 0) {

            $grace_sec = (($duration_seconds_needed - $worked_seconds_flexi) / 60) * 60; //ignore extra seconds

            //one hour max grace check.
            if ($grace_sec > 3600) { //if exceeded by more than 30 minutes

                //see if this punch was after 11.30 am

                //todo 12 to 3 pmghjghjhgjghjghjghj
                $morning_late = $c_punch_in->greaterThan($c_flexi_1030am->clone()->addSeconds(3600));
                $evening_late = $c_punch_out->lessThan($c_flexi_5pm->clone()->subSeconds(3600));

                if ($morning_late && !$evening_late) {
                    $computer_hint = $can_take_casual_fn ? 'casual_fn' : ($can_take_casual_an ? 'casual_an' : 'casual');
                } else if ($evening_late && !$morning_late) {
                    $computer_hint = $can_take_casual_an ? 'casual_an' : ($can_take_casual_fn ? 'casual_fn' : 'casual');
                } else if ($morning_late && $evening_late) {
                    $computer_hint =  'casual';
                } else {
                    //10.08 to 4.05
                    //find which end has more has more time diff. morning or evening
                    $morning_diff = $c_flexi_1030am->diffInSeconds($c_punch_in);
                    $evening_diff = $c_punch_out->diffInSeconds($c_flexi_5pm);
                    if ($morning_diff > $evening_diff)
                        $computer_hint = $can_take_casual_fn ? 'casual_fn' : ($can_take_casual_an ? 'casual_an' : 'casual');
                    else
                        $computer_hint = $can_take_casual_an ? 'casual_an' : ($can_take_casual_fn ? 'casual_fn' : 'casual');
                }

                //used when we show icons. if this is just two or three minutes late, dont show 1/2 cl icon
                //computer decides hint. this can be wrong.
                //this can also be used to show how many decisions pending for an employee in a month
                //we only count cl set by so/us. not based on hint

            }

            $grace_total_exceeded_one_hour = $grace_sec - 3600;
        }

        return [$computer_hint, $grace_total_exceeded_one_hour];
    }


    public function  calculateMonthlyAttendance($date, $aadhaar_ids = null, $aadhaar_to_empIds = null)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $date)->startOfMonth();
        $end_date = Carbon::createFromFormat('Y-m-d', $date)->endOfMonth();

  //      $date_ =  Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
      //  $isToday = $date_->isToday();

        if ($aadhaar_ids == null) {
            $aadhaar_ids =  $this->getAadhaaridsOfPunchingTracesForPeriod($start_date, $end_date)->pluck('aadhaarid');
        }
        // $emps = Employee::where('status', 'active')->where('has_punching', 1)->get();
        //if( $aadhaar_to_empIds == null)
        {
            $emps = Employee::wherein('aadhaarid', $aadhaar_ids)->get();
            $aadhaar_to_empIds = $emps->pluck('id', 'aadhaarid');
        }

        $punchings = Punching::with('leave')->whereBetween('date', [$start_date, $end_date])
            ->wherein('aadhaarid', $aadhaar_ids)
            ->get();

        $punchings_grouped = $punchings->groupBy('aadhaarid');
        //\Log::info('aadhaar_to_empIds count:' . $aadhaar_to_empIds);

        $data = collect([]);

        foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
            $emp_punchings = $punchings_grouped->has($aadhaarid) ?
                $punchings_grouped->get($aadhaarid) : null;

            $emp_new_monthly_attendance_data = [];
            $emp_new_monthly_attendance_data['aadhaarid'] = $aadhaarid;
            $emp_new_monthly_attendance_data['employee_id'] = $employee_id;
            $emp_new_monthly_attendance_data['month'] = $start_date->format('Y-m-d');
            $emp_new_monthly_attendance_data['total_grace_sec'] = 0;
            $emp_new_monthly_attendance_data['total_extra_sec'] = 0;
            $emp_new_monthly_attendance_data['total_grace_str'] = '';
            $emp_new_monthly_attendance_data['total_extra_str'] = '';
            $emp_new_monthly_attendance_data['cl_marked'] = 0;
            $emp_new_monthly_attendance_data['compen_marked'] = 0;
            $emp_new_monthly_attendance_data['total_grace_exceeded300_date'] = null;
            $emp_new_monthly_attendance_data['single_punchings'] = 0;
            $emp_new_monthly_attendance_data['cl_submitted'] = 0;

          //  \Log::info('aadhaarid:' . $aadhaarid);
            if ($emp_punchings) {
                $total_grace_sec =  $emp_punchings->sum('grace_sec');
                $emp_new_monthly_attendance_data['total_grace_sec'] = $total_grace_sec;
                $emp_new_monthly_attendance_data['total_grace_str'] = floor($total_grace_sec / 60);
                $total_extra_sec = $emp_punchings->sum('extra_sec');
                $emp_new_monthly_attendance_data['total_extra_sec'] = $total_extra_sec;
                $emp_new_monthly_attendance_data['total_extra_str'] = gmdate("H:i", $total_extra_sec);

                //see MarkHintDrawerComponent in frontend for possible hints
                $total_half_day_fn =  $emp_punchings->Where('hint', 'casual_fn')->count();
                $total_half_day_an =  $emp_punchings->where('hint', 'casual_an')->count();
                $total_full_day =  $emp_punchings->where('hint', 'casual')->count();
                $total_cl =   ($total_half_day_fn +  $total_half_day_an) / (float)2 + $total_full_day;
                $emp_new_monthly_attendance_data['cl_marked'] = $total_cl;
                $total_compen =  $emp_punchings->where('hint', 'comp_leave')->count();
                $emp_new_monthly_attendance_data['compen_marked'] = $total_compen;

                $total_cl_submitted =  $emp_punchings->sum(function ($punching) {
                    if($punching->leave_id == null || $punching->leave->leave_type != 'CL')
                        return 0;
                    if($punching->leave->leave_cat == 'F')
                        return $punching->leave?->active_status == 'N' || $punching->leave->active_status == 'Y' ? 1 : 0 ;

                    return $punching->leave?->active_status == 'N' || $punching->leave->active_status == 'Y' ? 0.5 : 0 ;

                });
                $emp_new_monthly_attendance_data['cl_submitted'] = $total_cl_submitted;

                $total_single_punchings =  $emp_punchings->where('punching_count', 1)->where('date', '<>', Carbon::today()->format('Y-m-d'))->count();
                $emp_new_monthly_attendance_data['single_punchings'] =$total_single_punchings;

                //find the day on which total grace time exceeded 300 minutes

                $date = $start_date->clone();
                $total_grace_till_this_date = 0;
                for ($i = 1; $i <= $start_date->daysInMonth; $i++) {
                    $d = $date->day($i);
                    $d_str = $d->format('Y-m-d');
                    $total_grace_till_this_date += $emp_punchings->where('date', $d_str)->first()?->grace_sec ?? 0;
                   // \Log::info('total_grace_till_this_date:' . $total_grace_till_this_date);
                    if ($total_grace_till_this_date > 300 * 60) {
                        $emp_new_monthly_attendance_data['total_grace_exceeded300_date'] = $d_str;
                        break;
                    }
                }
            }
            //  $emp_new_monthly_attendance_data['total_absent'] = 0;

            $data[] = $emp_new_monthly_attendance_data;
        }

        MonthlyAttendance::upsert(
            $data->all(),
            uniqueBy: ['month', 'aadhaarid'],
            update: [
                'total_grace_sec',  'total_extra_sec', 'cl_marked', 'employee_id',
                'total_grace_exceeded300_date', 'total_grace_str', 'total_extra_str',
                'compen_marked','cl_submitted','single_punchings'
            ]
        );

        return   $data;
    }


    public function calculateYearlyAttendance($date, $aadhaar_ids = null, $aadhaar_to_empIds = null)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $date)->startOfYear();
        $end_date = Carbon::createFromFormat('Y-m-d', $date)->endOfYear();

        if ($aadhaar_ids == null) {
            $aadhaar_ids   =  $this->getAadhaaridsOfPunchingTracesForPeriod($start_date, $end_date)->pluck('aadhaarid');
        }


        $emps = Employee::wherein('aadhaarid', $aadhaar_ids)->get();
        $aadhaar_to_empIds = $emps->pluck('id', 'aadhaarid');

        $monthlypunchings = MonthlyAttendance::whereBetween('month', [$start_date, $end_date])
            ->wherein('aadhaarid', $aadhaar_ids)
            ->get();

        $monthlypunchings_grouped = $monthlypunchings->groupBy('aadhaarid');
        //\Log::info('aadhaar_to_empIds count:' . $aadhaar_to_empIds);

        $data = collect([]);

        foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
            $emp_monthlypunchings = $monthlypunchings_grouped->has($aadhaarid) ?
                $monthlypunchings_grouped->get($aadhaarid) : null;

            // 'year',
            // 'cl_marked',
            // 'cl_submitted',
            // 'compen_marked',
            // 'compen_submitted',
            // 'other_leaves_marked',

            $emp_new_yearly_attendance_data = [];
            $emp_new_yearly_attendance_data['aadhaarid'] = $aadhaarid;
            $emp_new_yearly_attendance_data['employee_id'] = $employee_id;
            $emp_new_yearly_attendance_data['year'] = $start_date->format('Y-m-d');

            $emp_new_yearly_attendance_data['cl_marked'] = 0;
            $emp_new_yearly_attendance_data['cl_submitted'] = 0;
            $emp_new_yearly_attendance_data['compen_marked'] = 0;
            $emp_new_yearly_attendance_data['compen_submitted'] = 0;
            $emp_new_yearly_attendance_data['other_leaves_marked'] = 0;
            $emp_new_yearly_attendance_data['single_punchings'] =0;

          //  \Log::info('aadhaarid:' . $aadhaarid);
            if ($emp_monthlypunchings) {

                $total_cl =  $emp_monthlypunchings->sum('cl_marked');
                $emp_new_yearly_attendance_data['cl_marked'] = $total_cl;

                $total_cl_submitted =  $emp_monthlypunchings->sum('cl_submitted');
                $emp_new_yearly_attendance_data['cl_submitted'] = $total_cl_submitted;

                $total_compen =  $emp_monthlypunchings->sum('compen_marked');
                $emp_new_yearly_attendance_data['compen_marked'] = $total_compen;

                $total_single_punchings =  $emp_monthlypunchings->sum('single_punchings');
                $emp_new_yearly_attendance_data['single_punchings'] = $total_single_punchings;
            }

            $data[] = $emp_new_yearly_attendance_data;
        }

        YearlyAttendance::upsert(
            $data->all(),
            uniqueBy: ['year', 'aadhaarid'],
            update: [
                'employee_id',
                'cl_marked',  'cl_submitted', 'compen_marked',
                'compen_submitted', 'other_leaves_marked', 'other_leaves_submitted','single_punchings'
            ]
        );

        return   $data;
    }
}
