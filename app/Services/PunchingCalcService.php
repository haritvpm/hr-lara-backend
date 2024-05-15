<?php

namespace App\Services;

use Auth;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Punching;
use App\Models\GraceTime;
use App\Models\OfficeTime;
use App\Models\GovtCalendar;
use App\Models\PunchingTrace;
use App\Models\YearlyAttendance;
use App\Models\EmployeeToSection;
use App\Models\MonthlyAttendance;
use App\Services\EmployeeService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;

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
        \Log::info('calculate - start for date=' . $date);
        //grab punching trace for the employees.
        $all_punchingtraces =  $this->getPunchingTracesForDay($date,  $aadhaar_ids);

        $allemp_punchingtraces_grouped =  $all_punchingtraces->groupBy('aadhaarid');

        $aadhaar_to_empIds = [];
        $emp_ids = [];


        if ($aadhaar_ids == null) {
            $aadhaar_ids  = $all_punchingtraces->pluck('aadhaarid');
            //also get all emloyee to section mappings and get those employees
            $all_section_emp_ids = EmployeeToSection::duringPeriod( $date,$date )->pluck('employee_id');
            $aadhaar_ids_of_section_emps = Employee::wherein('id', $all_section_emp_ids)->pluck('aadhaarid');
            $aadhaar_ids = $aadhaar_ids->merge($aadhaar_ids_of_section_emps)->unique();
        }
        // $emps = Employee::where('status', 'active')->where('has_punching', 1)->get();

        $emps = Employee::wherein('aadhaarid', $aadhaar_ids)->get(['id', 'aadhaarid']);
        $aadhaar_to_empIds = $emps->pluck('id', 'aadhaarid');
        $emp_ids = $emps->pluck('id');

        //we need Punching if it exists, to get hints like half day leave
        // $allemp_punchings_existing  =  $this->getPunchingsForDay($date,  $aadhaar_ids)->groupBy('aadhaarid');

        //get office time groups with effective date as of this $date

        $time_groups  = OfficeTime::getOfficeTimes($date);
        //dd($time_groups);
        $employee_section_maps =  EmployeeService::getDesignationOfEmployeesOnDate($date,  $emp_ids);
        //for each empl, calculate

        $calender = GovtCalendar::where('date', $date)->first();

        $data = collect([]);

        foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
            $emp_new_punching_data = [];
            $emp_new_punching_data['date'] = $date; //->format('Y-m-d');
            $emp_new_punching_data['aadhaarid'] = $aadhaarid;
            $emp_new_punching_data['employee_id'] = $employee_id;
            $emp_new_punching_data['time_group'] = null;

            //this employee might not have been mapped to a section
            if ($employee_section_maps->has($aadhaarid)) {
                $emp_new_punching_data['designation'] = $employee_section_maps[$aadhaarid]['designation'];
                // $emp_new_punching_data['section'] = $employee_section_maps[$aadhaarid]['section'];
                $emp_new_punching_data['name'] = $employee_section_maps[$aadhaarid]['name'];
                $time_group_name = $employee_section_maps[$aadhaarid]['time_group'] ?? 'default';
                $emp_new_punching_data['time_group'] =  $time_group_name;

                //only call this if we have an employee section map
                //use upsert insetad of updateorcreate inside calculateforemployee
                // if($employee_section_maps[$aadhaarid]['time_group']){
                //     dd($employee_section_maps[$aadhaarid]);
                // }
              //  dd($time_group_name);
            //   if(!$time_groups->where('groupname', $time_group_name)->first()){
            //     dd($time_group_name);
            //   }

                $time_group = $time_groups->where('groupname', $time_group_name)->first()->toArray() ;
               // dd($time_group);

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
                'grace_total_exceeded_one_hour', 'computer_hint', 'hint',
                'single_punch_type',
                'time_group',
                'is_unauthorised', 'duration_sec_needed'

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
\Log::info("calender" . $calender);
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

        $punching_existing = Punching::with('leave')->where('date', $date)
            ->where('aadhaarid', $aadhaarid)
            ->first();

        $hint = $punching_existing?->hint ?? null;
        $single_punch_type = $punching_existing?->single_punch_type ?? null;
        $fetchComplete = $calender->attendance_trace_fetch_complete ?? false;

        //    \Log::info('$punching_existing hint:' . $punching_existing['hint']);
        //\Log::info('hint:' . $hint);
        ///////////////////////
        //$single_punch_type =  null; //temp uncomment to reset
        //////////////////////
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
        $emp_new_punching_data['single_punch_type'] = $single_punch_type;//temp uncomment.
        $emp_new_punching_data['is_unauthorised'] = null;


        $duration_sec = 0;

        //get office times for this time group
        [$flexi_15minutes,
            $normal_fn_in,
            $normal_fn_out,
            $normal_an_in,
            $normal_an_out,
            $c_flexi_10am,
            $c_flexi_530pm,
            $c_flexi_1030am,
            $c_flexi_5pm,
            $time_after_which_unauthorised,
            $can_take_casual_fn,
            $can_take_casual_an,
            $duration_seconds_needed,
            $max_grace_seconds
        ] = $this->getOfficeTimesForTimeGroup($date, $calender, $time_group);


        //Decide if this is punchin or out
        //note, there can be multiple punchings and still be single punch type as employy can punch twice within seconds
        if (($punch_count  == 1 || $single_punch_type)) {
            //TODO is it punch in or out ? has to be set by under
            $punch = $punchingtraces[0];
            $c_punch = Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $isPunchIn = (!$single_punch_type || ($single_punch_type && $single_punch_type == 'in')) ? true : false;

            if(!$single_punch_type){ //not set by controller
                if($time_group['groupname'] != 'parttime'){
                    $half_time = $normal_fn_in->clone()->addSeconds($normal_fn_in->diffInSeconds($normal_an_out) / 2);
                    //if punch is one hour before normal_an_out, make this punchout instead of punchin.
                    if($c_punch->gt($half_time) /*&& $c_punch->lt($normal_an_out->clone()->subSeconds(3600))*/){
                        $isPunchIn = false;
                    }
                } else {
                    //find half-time between $normal_fn_in and  $normal_fn_out and decide if this is punchin or out
                    $half_time = $normal_fn_in->clone()->addSeconds($normal_fn_in->diffInSeconds($normal_fn_out) / 2);
                    if($c_punch->gt($half_time)){
                        $isPunchIn = false;
                    }
                }
            }


            if( $isPunchIn || $single_punch_type == 'in'){
                $emp_new_punching_data['punchin_trace_id'] = $punch['id'];
                $c_punch_in =  $c_punch->clone();
                $emp_new_punching_data['in_datetime'] =  $c_punch_in->toDateTimeString();
                if(!$single_punch_type && $fetchComplete){ //if single punch type is set, dont change it
                    $emp_new_punching_data['single_punch_type'] = $single_punch_type = 'in';
                }
            } else {
                $punch = $punchingtraces[$punch_count - 1];//take last in case there are multiple punchings
                $c_punch = Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
                $emp_new_punching_data['punchout_trace_id'] = $punch['id'];
                $c_punch_out = $c_punch->clone();
                $emp_new_punching_data['out_datetime'] =  $c_punch_out->toDateTimeString();
                if(!$single_punch_type && $fetchComplete){
                    $emp_new_punching_data['single_punch_type'] = $single_punch_type = 'out';
                }
            }


        }
       // if($aadhaarid == '20094472'){ dd($emp_new_punching_data['single_punch_type']);}
        if ($punch_count >= 2 && $single_punch_type == null) {
            $punch = $punchingtraces[0];
            $emp_new_punching_data['punchin_trace_id'] = $punch['id'];
            $c_punch_in = Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $emp_new_punching_data['in_datetime'] =  $c_punch_in->toDateTimeString();

            $punch = $punchingtraces[$punch_count - 1];
            $emp_new_punching_data['punchout_trace_id'] = $punch['id'];
            $c_punch_out =  Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $emp_new_punching_data['out_datetime'] =  $c_punch_out->toDateTimeString();
        }

        //check if leave approved. if so,  calculate grace only if half day leave.
        //safiya on apr 2024 4, submitted half day 'other' leave for election training. so need to calculate grace.
        [$hasLeave, $isFullLeave, $isFnLeave,$isAnLeave] = $this->checkLeaveExists($punching_existing);
        $isHoliday = $calender->govtholidaystatus || $hint == 'RH';
        $date_carbon = Carbon::createFromFormat('Y-m-d', $date);
        $isSinglePunching =  $single_punch_type != null;


        $emp_new_punching_data['duration_sec_needed'] = $duration_seconds_needed;


        if ($c_punch_in && $c_punch_out) {

            $duration_sec = $c_punch_in->diffInSeconds($c_punch_out);
            $emp_new_punching_data['duration_sec'] = $duration_sec;
            $emp_new_punching_data['duration_str'] = floor($duration_sec / 3600) . gmdate(":i:s", $duration_sec % 3600);



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
                if (($can_take_casual_fn && /*$computer_hint == 'casual_fn') ||*/ $hint == 'casual_fn') ||
                    ($hasLeave && $isFnLeave)) {

                    $c_flexi_10am = $normal_an_in->clone()->subMinutes($flexi_15minutes); //2pm -15
                    $c_flexi_1030am = $normal_an_in->clone()->addMinutes($flexi_15minutes); //2pm +15
                    $duration_seconds_needed =  $normal_an_in->diffInSeconds($normal_an_out); //3.15 hour

                    $isFullDay = false;
                } else
                if (($can_take_casual_an && /*$computer_hint == 'casual_an') ||*/ $hint == 'casual_an') ||
                    ($hasLeave && $isAnLeave)) {
                    $c_flexi_530pm = $normal_fn_out->clone()->addMinutes($flexi_15minutes); //1.15 +15
                    //$c_flexi_5pm = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '13:00:00'); //1.15 - 15
                    //$duration_seconds_needed = 3 * 3600;
                    $duration_seconds_needed =  $normal_fn_in->diffInSeconds($normal_fn_out); //3.00 hour
                    $isFullDay = false;
                } else if ($computer_hint == 'casual') {
                    //punched, but not enough time worked or office ends and 3 pm/12pm situations

                }
            }

            //if punches in before 10 am or punches out after 5.30, dont take that, use 10am and 5.30
            $c_start = $c_punch_in->lessThan($c_flexi_10am)  ? $c_flexi_10am : $c_punch_in;
            $c_end = $c_punch_out->greaterThan($c_flexi_530pm)  ? $c_flexi_530pm : $c_punch_out;

            //since $c_flexi_1030am might be changed, recalculate this
            $time_after_which_unauthorised = $c_flexi_1030am->clone()->addSeconds($max_grace_seconds);

            //if like from 6 to 9 am, ''casual' will be set by setHintIfPunchMoreThanOneHourLate


            $isFullDayleaveHint = $hint && $hint != 'casual_an' && $hint != 'casual_fn' && $hint != 'clear' ;
            $isFullDayleave =  $isFullDayleaveHint;
            //if approved leave exists, use that instead of hint
            if($hasLeave ){
                $isFullDayleave = $isFullLeave;
            }



            if (!$isHoliday && !$isFullDayleave && !$isSinglePunching) //if hint exists, no need to use computer hint for else
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
            } else if(!$isHoliday && !$isSinglePunching) { //if holiday, let them get compen directly
                //punched, but not enough time worked or office ends and 3 pm/12pm situations
                //set grace as 0. but allow extra time as whole day's time
                $extra_sec = $duration_sec;
                $emp_new_punching_data['extra_sec'] = $extra_sec;
                $emp_new_punching_data['extra_str'] = (int)($extra_sec / 60);
            }

        }

        if(/*$fetchComplete &&*/ !$isHoliday && $isSinglePunching) {
            if($single_punch_type == 'in'){
                if($c_punch_in->greaterThan($normal_fn_in)){
                    $grace_sec = $c_punch_in->diffInSeconds($normal_fn_in,true);
                    $emp_new_punching_data['grace_sec'] = $grace_sec;
                    $emp_new_punching_data['grace_str'] = (int)($grace_sec / 60);
                }
            } else if ($single_punch_type == 'out'){
                if($c_punch_out->lessThan($normal_an_out)){
                    $grace_sec = $normal_an_out->diffInSeconds($c_punch_out,true);
                    $emp_new_punching_data['grace_sec'] = $grace_sec;
                    $emp_new_punching_data['grace_str'] = (int)($grace_sec / 60);
                }
            }

        }

        //even i punched, can be unauthorised if punched after 11.30 am
        $computer_hint = $emp_new_punching_data['computer_hint'] ?? null;
        $canSetUnauthorised = $date_carbon->lt(Carbon::today()) ||
                                ($date_carbon->isToday() && Carbon::now()->greaterThan($time_after_which_unauthorised)) ;

        $canSetUnauthorised = $canSetUnauthorised && !$isHoliday && !$hasLeave ;
        $canSetUnauthorised = $canSetUnauthorised && (!$hint || $hint == 'clear');

        if( $canSetUnauthorised ){
            if ($punch_count >= 1) {

                if( $c_punch_in && $c_punch_in->greaterThan($time_after_which_unauthorised)){
                    $emp_new_punching_data['is_unauthorised'] = true;

                }
            }
            else
            if ($punch_count == 0){
                //if no punching even after 1 hour from c_flexi_1030am and there is no leave or hint, set 'unauthorised' hint
             //   \Log::info('Carbon::now() ' . Carbon::now());
               // \Log::info('time_after_which_unauthorised ' . $time_after_which_unauthorised);

                $emp_new_punching_data['is_unauthorised'] = true;


            }
        }

        // \Log::info($emp_new_punching_data);

        return $emp_new_punching_data;


        //extra time
    }

    private function getOfficeTimesForTimeGroup( $date, $calender, $time_group )
    {
        $max_grace_seconds = 3600;
        $flexi_15minutes = $time_group['flexi_minutes'] ?? 15;
        //use today's date. imagine legislation punching out next day. our flexiend is based on today
        //get employee time group. now assume normal

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
        $time_after_which_unauthorised = $c_flexi_1030am->clone()->addSeconds($max_grace_seconds);

        //office ends at noon or 3.00 pm
        $office_ends_at_300pm = $calender->office_ends_at === '3pm';
        $office_ends_at_noon = $calender->office_ends_at === 'noon';
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

        return [
                $flexi_15minutes,
                $normal_fn_in,
                $normal_fn_out,
                $normal_an_in,
                $normal_an_out,
                $c_flexi_10am,
                $c_flexi_530pm,
                $c_flexi_1030am,
                $c_flexi_5pm,
                $time_after_which_unauthorised,
                $can_take_casual_fn,
                $can_take_casual_an,
                $duration_seconds_needed,
                $max_grace_seconds
        ];

    }


    private function checkLeaveExists($punching_existing)
    {
        $hasLeave = $isFullLeave = $isFnLeave = $isAnLeave = false;
        if ($punching_existing && $punching_existing->leave_id) {
            $leave = $punching_existing->leave_id ? $punching_existing->leave : null;

            if ($leave && $leave->leave_type && (/*$leave->active_status == 'N' ||*/ $leave->active_status == 'Y')) {
                $hasLeave = true;
                if($leave->leave_cat == 'F'){
                    $isFullLeave = true;
                } else if($leave->leave_cat == 'H') {
                    if($leave->time_period == 'FN'){
                        $isFnLeave = true;
                    } else {
                        $isAnLeave = true;
                    }
                }

            }
        }
        return [$hasLeave, $isFullLeave, $isFnLeave, $isAnLeave];
    }

    private function setHintIfPunchMoreThanOneHourLate(
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
            if ($grace_sec > 3600) { //if exceeded by more than 60 minutes

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
        $date_input =  Carbon::createFromFormat('Y-m-d', $date);
        $start_date = $date_input->clone()->startOfMonth();
        $end_date = $date_input->clone()->endOfMonth();
        $month_db_day = $start_date->clone();
        $month_mode = config('app.month_mode');
        if($month_mode == 'spark'){
         //   dd( $date_input->day);

            if( $date_input->day >= 16  ){
                $start_date = $date_input->clone()->startOfMonth()->addDays(15);
                $end_date = $date_input->clone()->addMonth()->startOfMonth()->addDays(14);
                $month_db_day = $end_date->clone();
            }
            else
            {
                $start_date = $date_input->clone()->subMonth()->startOfMonth()->addDays(15);
                $end_date = $date_input->clone()->startOfMonth()->addDays(14);
                $month_db_day = $start_date->clone();
         //   dd( $month_db_day->format('Y-m-d'));


            }
        }


  //      $date_ =  Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
      //  $isToday = $date_->isToday();

        if ($aadhaar_ids == null) {
            $aadhaar_ids =  $this->getAadhaaridsOfPunchingTracesForPeriod($start_date, $end_date)->pluck('aadhaarid');
        }
        // $emps = Employee::where('status', 'active')->where('has_punching', 1)->get();
        //if( $aadhaar_to_empIds == null)
        {
            $emps = Employee::with('grace_group')->wherein('aadhaarid', $aadhaar_ids)->get();
            $aadhaar_to_empIds = $emps->pluck('id', 'aadhaarid');
        }

        $punchings = Punching::with('leave')->whereBetween('date', [$start_date, $end_date])
            ->wherein('aadhaarid', $aadhaar_ids)
            ->get();

        $punchings_grouped = $punchings->groupBy('aadhaarid');
        //\Log::info('aadhaar_to_empIds count:' . $aadhaar_to_empIds);

        $grace_groups = GraceTime::getGraceGroups($start_date);

        $data = collect([]);

        foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
            $emp_punchings = $punchings_grouped->has($aadhaarid) ?
                $punchings_grouped->get($aadhaarid) : null;

            $emp_new_monthly_attendance_data = [
                'aadhaarid' => $aadhaarid,
                'employee_id' => $employee_id,
                'month' => $month_db_day->startOfMonth()->format('Y-m-d'),
                'total_grace_sec' => 0,
                'total_extra_sec' => 0,
                'total_grace_str' => '',
                'total_extra_str' => '',
                'cl_marked' => 0,
                'compen_marked' => 0,
                'total_grace_exceeded300_date' => null,
                'single_punchings' => 0,
                'cl_submitted' => 0,
                'grace_minutes' => 300,
                'start_date' => $start_date->format('Y-m-d'),
                'end_date' => $end_date->format('Y-m-d'),
                'single_punchings_regularised' => 0,
                'unauthorised_count' => 0,
            ];

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

                $total_unauthorised =  $emp_punchings->where('is_unauthorised', 1)->count();
                $emp_new_monthly_attendance_data['unauthorised_count'] = $total_unauthorised;
                // if('69038788' == $aadhaarid){
                //     dd($total_unauthorised);
                // }

                // $total_single_punchings =  $emp_punchings->where('punching_count', 1)->where('date', '<>', Carbon::today()->format('Y-m-d'))->count();
                //if this is calculated today, exclude today's single punchings
                $total_single_punchings = $emp_punchings->where('date', '<>', Carbon::today()->format('Y-m-d'))
                                    ->filter(function ($value, $key) {
                                    return $value->punching_count == 1 || $value->single_punch_type != null ;
                                });

                $emp_new_monthly_attendance_data['single_punchings'] =$total_single_punchings->count();


                $total_single_punchings_regularised = $emp_punchings->whereNotNull ('single_punch_regularised_by')->count();
                $emp_new_monthly_attendance_data['single_punchings_regularised'] = $total_single_punchings_regularised;
                //find the day on which total grace time exceeded 300 minutes


                $total_grace_till_this_date = 0;
                $emp = $emps->where('aadhaarid', $aadhaarid)->first();

                $emp_grace_group_title = $emp?->grace_group?->title ?? 'default';
                $grace_group = $grace_groups->where('title', $emp_grace_group_title)->first();

                $grace_mins = $grace_group->minutes ?? 300;
                $emp_new_monthly_attendance_data['grace_minutes'] = $grace_mins;
                // if($aadhaarid == '66068827'){
                //     dd($grace_group);
                // }

                //for each day from $start_date to $end_date, calculate total grace time till that date
                $period = CarbonPeriod::create($start_date, $end_date);
                foreach ($period as $d) {
                    $d_str = $d->format('Y-m-d');
                    $total_grace_till_this_date += $emp_punchings->where('date', $d_str)->first()?->grace_sec ?? 0;
                   // \Log::info('total_grace_till_this_date:' . $total_grace_till_this_date);
                    if ($total_grace_till_this_date > ($grace_mins* 60)) {
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
                'compen_marked','cl_submitted','single_punchings', 'grace_minutes', 'start_date', 'end_date',
                'single_punchings_regularised', 'unauthorised_count',
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

            $emp_new_yearly_attendance_data = [
                'aadhaarid' => $aadhaarid,
                'employee_id' => $employee_id,
                'year' => $start_date->format('Y-m-d'),
                'cl_marked' => 0,
                'cl_submitted' => 0,
                'compen_marked' => 0,
                'compen_submitted' => 0,
                'other_leaves_marked' => 0,
                'single_punchings' => 0,
                'single_punchings_regularised'=> 0,
                'unauthorised_count'=> 0,
            ];


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

                $total_single_punchings_regularised =  $emp_monthlypunchings->sum('single_punchings_regularised');
                $emp_new_yearly_attendance_data['single_punchings_regularised'] = $total_single_punchings_regularised;

                $total_unauthorised =  $emp_monthlypunchings->sum('unauthorised_count');
                $emp_new_yearly_attendance_data['unauthorised_count'] = $total_unauthorised;
            }

            $data[] = $emp_new_yearly_attendance_data;
        }

        YearlyAttendance::upsert(
            $data->all(),
            uniqueBy: ['year', 'aadhaarid'],
            update: [
                'employee_id',
                'cl_marked',  'cl_submitted', 'compen_marked',
                'compen_submitted', 'other_leaves_marked', 'other_leaves_submitted','single_punchings',
                'single_punchings_regularised', 'unauthorised_count'

            ]
        );

        return   $data;
    }
}
