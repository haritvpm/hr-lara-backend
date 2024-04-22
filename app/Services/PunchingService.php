<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Auth;
use App\Models\GovtCalendar;
use App\Models\Punching;
use App\Models\PunchingTrace;
use App\Models\SuccessPunching;
use App\Models\Calender;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use App\Models\MonthlyAttendance;
use App\Models\OfficeTime;
use App\Models\EmployeeToSection;

class PunchingService
{


    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function fetchSuccessAttendance($reportdate)
    {

        $apikey =  env('AEBAS_KEY');
        $offset = 0;

        $islocal_test = false;
        $count =  $islocal_test  ? 10000 : 500;

        // should be in format 2024-02-11
        if (!$this->validateDate($reportdate)) {
            //date is in dd-mm-yy
            $reportdate = Carbon::createFromFormat(config('app.date_format'), $reportdate)->format('Y-m-d');
        }

        $insertedcount = 0;
        $pen_to_aadhaarid = [];

        $govtcalender = $this->getGovtCalender($reportdate);
        if ($govtcalender->success_attendance_fetched) {
            $offset = $govtcalender->success_attendance_rows_fetched;
        }

        for (;; $offset += $count) {


            $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendance/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";

            if ($islocal_test) $url = 'http://localhost:3000/data';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->get($url);

            if ($response->status() !== 200) {
                // \Session::flash('message-danger',  $response->status());
                Log::error('Response for fetchSuccessAttendance:' . $response->status());
                break;
            }
            $jsonData = $response->json();
            $jsonData = $jsonData['successattendance'];
            // dd($jsonData);

            //now this is ugly repeated calls to db. lets optimize later
            for ($i = 0; $i < count($jsonData); $i++) {
                $dataItem = $jsonData[$i];
                $dateIn = null;
                $dateOut = null;
                $intime = null;
                $outtime = null;
                $this->processPunchingData($jsonData[$i], $dateIn, $intime, $dateOut, $outtime);
                //user may punchin but not punchout. so treat these separately

                //org_emp_code from api can be klaid, mobilenumber or empty.
                $org_emp_code = $dataItem['org_emp_code'];
                $attendanceId = $dataItem['emp_id'];
                if ('0000-00-00 00:00:00' == $dataItem['in_time'])  $dataItem['in_time'] = null;
                if ('0000-00-00 00:00:00' == $dataItem['out_time'])  $dataItem['out_time'] = null;

                //date-aadhaarid-pen composite keys wont work if we give null. so something to pen
                //punchout date can be diff to punchin date, not sure
                $punch = null;
                if ($dateIn && $intime && $dateOut && $outtime && ($dateIn === $dateOut)) {
                    $matchThese = ['aadhaarid' => $attendanceId, 'date' => $dateIn];
                    $vals = [
                        'punch_in' => $intime, 'punch_out' => $outtime, 'pen' => '-', 'punchin_from_aebas' => true,
                        'punchout_from_aebas' =>     true, 'in_device' => $dataItem['in_device_id'], 'in_time' => $dataItem['in_time'],
                        'out_device' =>  $dataItem['out_device_id'], 'out_time' => $dataItem['out_time'],
                        'at_type' => $dataItem['at_type']
                    ];

                    if ($org_emp_code != '')  $vals['pen'] = $org_emp_code;


                    $punch = SuccessPunching::updateOrCreate($matchThese, $vals);
                } else
                if ($dateIn && $intime) {
                    // $date = Carbon::createFromFormat('Y-m-d', $dateIn)->format(config('app.date_format'));
                    //org_emp_code can be null. since empty can cause unique constraint violations, dont allow
                    $matchThese = ['aadhaarid' => $attendanceId, 'date' => $dateIn];
                    $vals = [
                        'punch_in' => $intime, 'pen' => '-', 'punchin_from_aebas' => true, 'punchout_from_aebas' => false,
                        'in_device' => $dataItem['in_device_id'], 'in_time' => $dataItem['in_time'], 'out_device' =>  $dataItem['out_device_id'], 'out_time' => $dataItem['out_time'], 'at_type' => $dataItem['at_type']
                    ];

                    if ($org_emp_code != '') $vals['pen'] = $org_emp_code;

                    $punch = SuccessPunching::updateOrCreate($matchThese, $vals);
                } else
                if ($dateOut && $outtime) {
                    // $date = Carbon::createFromFormat('Y-m-d', $dateOut)->format(config('app.date_format'));
                    $matchThese = ['aadhaarid' => $attendanceId, 'date' => $dateOut];
                    $vals = [
                        'punch_out' => $outtime, 'pen' => '-', 'punchin_from_aebas' => false, 'punchout_from_aebas' => true,
                        'in_device' => $dataItem['in_device_id'], 'in_time' => $dataItem['in_time'],
                        'out_device' => $dataItem['out_device_id'], 'out_time' => $dataItem['out_time'], 'at_type' => $dataItem['at_type']
                    ];
                    if ($org_emp_code != '')  $vals['pen'] = $org_emp_code;

                    $punch = SuccessPunching::updateOrCreate($matchThese, $vals);
                } else {
                    \Log::info('found punching fetch edge case');
                }
                $insertedcount++;


                if ($org_emp_code != '' && $org_emp_code != null) {
                    $pen_to_aadhaarid[$org_emp_code] = $attendanceId;
                }
            }
            //if reached end of data, break
            if (count($jsonData) <  $count) {

                break;
            }
        }

        $calenderdate = Calender::where('date', $reportdate)->first();
        if ($calenderdate && $insertedcount) {
            $calenderdate->update(['punching' => 'AEBAS']);
        }

        $totalrowsindb  = PunchingTrace::where('date', $reportdate)->count();

        $govtcalender->update([

            'success_attendance_fetched' =>  $calender->success_attendance_fetched + 1,
            'success_attendance_rows_fetched' => $totalrowsindb,
            'success_attendance_lastfetchtime' => Carbon::now(),

        ]);

        if ($insertedcount) {
            $this->makePunchingRegister($reportdate);
        }

        if (count($pen_to_aadhaarid)) {
            //Update our employee db with aadhaarid from api
            //since org_emp_code can be empty or even mobile number, make sure this is our pen
            $emps = Employee::select('id', 'pen', 'aadhaarid')
                ->wherein('pen', array_keys($pen_to_aadhaarid))->get();
            foreach ($emps->chunk(1000) as $chunk) {
                $cases = [];
                $ids = [];
                $params_aadhaarid = [];

                foreach ($chunk as $emp) {
                    if (!$emp->aadhaarid || $emp->aadhaarid == '') { //only if it is not set already
                        if (array_key_exists($emp->pen, $pen_to_aadhaarid)) {
                            $cases[] = "WHEN '{$emp->pen}' then ?";
                            $params_aadhaarid[] = $pen_to_aadhaarid[$emp->pen];
                            $ids[] = $emp->id;
                        }
                    }
                }

                $ids = implode(',', $ids);
                $cases = implode(' ', $cases);

                if (!empty($ids)) {
                    //dd( $params_aadhaarid);
                    \DB::update("UPDATE employees SET `aadhaarid` = CASE `pen` {$cases} END WHERE `id` in ({$ids})", $params_aadhaarid);
                }
            }
        }

        return $insertedcount;
    }

    private function processPunchingData($dataItem, &$dateIn, &$intime,  &$dateOut, &$outtime)
    {
        $in_time = $dataItem['in_time'] ?? null;

        //this is like "2024-02-07 07:13:47". so separate date and time
        if ($in_time && strlen($in_time) && !str_contains($in_time, "0000-00-00")) {
            $datetime = explode(' ', $in_time);
            // "out_time": "0000-00-00 00:00:00",

            $dateIn = $datetime[0];
            //$date = Carbon::createFromFormat('Y-m-d', $request->query('reportdate'))->format('Y-m-d');
            $intime = date('H:i', floor(strtotime($datetime[1]) / 60) * 60);
        }

        $out_time = $dataItem['out_time'] ?? null;
        //this is like "2024-02-07 07:13:47". so separate date and time
        if ($out_time && strlen($out_time) && !str_contains($out_time, "0000-00-00")) {

            $datetime = explode(' ', $out_time);
            $dateOut = $datetime[0];

            //if punchin, round down else round up
            $outtime = date('H:i', ceil(strtotime($datetime[1]) / 60) * 60);
        }
    }

    private function makePunchingRegister($reportdate)
    {
        $success_punchs = Punching::where('date', $reportdate)->get();

        foreach ($success_punchs as $dataItem) {

            //find employee
            $emp = Employee::where('aadhaarid',  $dataItem->emp_id)->first();
            if (!$emp) continue;
            $duration = "0";

            if ($dataItem['at_type'] == 'C') {
                $datein = Carbon::parse($dataItem->in_time);
                $dateout = Carbon::parse($dataItem->out_time);
                $duration = $dateout->diff($datein)->format('%H:%i:%s');
            }
        }
    }


    public function getGovtCalender($reportdate)
    {
        $calender = GovtCalendar::where('date', $reportdate)->first();
        if ($calender) {
            //if( $calender->attendance_today_trace_fetched)
            {
                //  \Log::info('calendear date exists-' . $reportdate);

                // $offset = $calender->attendance_today_trace_rows_fetched;
            }
        } else {
            // \Log::info('calendear date not exists-' . $reportdate);

            $calender = new GovtCalendar();
            //  $reportdate = Carbon::createFromFormat('Y-m-d', $reportdate)->format(config('app.date_format'));
            \Log::info('calendear date ncreated -' . $reportdate);

            $calender->date = $reportdate;

            //$calender->attendance_today_trace_fetched = 0;
            $calender->attendance_today_trace_rows_fetched = 0;


            //$calender->success_attendance_fetched = 0;
            $calender->success_attendance_rows_fetched = 0;

            $calender->save();
        }

        return  $calender;
    }

    public function fetchTrace($fetchdate = null)
    {
        $apikey =  env('AEBAS_KEY');
        // \Log::info($apikey );


        $offset = 0;
        $count = 500; //make it to 500 in prod


        // should be in format 2024-02-11
        $date = Carbon::now()->endOfDay();
        $reportdate = Carbon::now()->format('Y-m-d'); //today
        if ($fetchdate) {
            // should be in format 2024-02-11
            if (!$this->validateDate($fetchdate)) {
                //date is in dd-mm-yy
                $date =  Carbon::createFromFormat(config('app.date_format'), $fetchdate);
                $reportdate = $date->format('Y-m-d');
            } else {
                $date =  Carbon::createFromFormat('Y-m-d', $fetchdate);
                $reportdate = $fetchdate;
            }
        }

        //do not call trace if this is a future date

        if ($date > Carbon::now()->endOfDay()) {
            \Log::info('fetchTrace - future date ignoring');
            return 0;
        }


        //check calender for this date's count.

        $govtcalender = $this->getGovtCalender($reportdate);
        $offset = $govtcalender->attendance_today_trace_rows_fetched;

        //check last fetch time. if it less than 5 minutes, dont fetch

        if ($govtcalender->attendancetodaytrace_lastfetchtime) {
            $lastfetch =  Carbon::parse($govtcalender->attendancetodaytrace_lastfetchtime);
            $diff = Carbon::now()->diffInMinutes($lastfetch);
            \Log::info('diff=' . $diff);
            if ($diff < 5) {
                \Log::info('fetchTrace - last fetched in less than five minutes- ignoring');
                return 0;
            }
        }

        $insertedcount = 0;
        $attendance_trace_fetch_complete = false;
        for (;; $offset += $count) {

            $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendancetodaytrace/offset/{$offset}/count/{$count}/apikey/{$apikey}";
            $returnkey = "attendancetodaytrace";

            if ($fetchdate && !$date->isToday()) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/trace/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";
                $returnkey = "attendancetrace";
                $attendance_trace_fetch_complete = true;
            }



            // $url = 'http://localhost:3000/data';
            \Log::info($url);
            $response = Http::timeout(60)->retry(3, 100)->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->get($url);


            if ($response->status() !== 200) {
                //  \Session::flash('message-danger',  $response->status());
                \Log::error('Response for fetchAPI:' . $response->status());
                return;
                //break;
            }
            $jsonData = $response->json();
            $jsonData = $jsonData ? $jsonData[$returnkey] : [];

            \Log::info('fetched rows:' . count($jsonData));

            $datatoinsert = [];
            for ($i = 0; $i < count($jsonData); $i++) {
                //ignore errors



                //if(  $jsonData['attendance_type'] != 'E' && $jsonData['auth_status'] == 'Y'  )
                {
                    // assert($reportdate === $jsonData[$i]['att_date']);
                    $datatoinsert[] = $this->mapTraceToDBFields($offset + $i, $jsonData[$i]);
                }
            }



            $error = 0;
            try {
                //DB::transaction(function () use ($datatoinsert, $jsonData, &$error) {
                //All databases except SQL Server require the columns in the second argument of the upsert method to have a "primary" or "unique" index.
                //In addition, the MySQL database driver ignores the second argument of the upsert method and always uses the "primary" and "unique" indexes of the table to detect existing records.
                PunchingTrace::upsert($datatoinsert, ['aadhaarid', 'att_date', 'att_time']);
                $insertedcount += count($jsonData);
                //  });

            } catch (Exception $e) {
                //  $error = 1;
                throw new Exception($e->getMessage());
            }



            //if reached end of data, break
            if ($error ||  (count($jsonData) < $count)) {

                break;
            }
        }

        \Log::info('Newly fetched rows:' . $insertedcount);

        //$totalrowsindb  = PunchingTrace::where('att_date',$reportdate)->count();

        if ($insertedcount) {
            $govtcalender->update([
                //          'attendance_today_trace_fetched' =>  $govtcalender->attendance_today_trace_fetched+1,
                'attendance_today_trace_rows_fetched' => $govtcalender->attendance_today_trace_rows_fetched + $insertedcount,
                'attendancetodaytrace_lastfetchtime' => Carbon::now(), //today
                'attendance_trace_fetch_complete' => $attendance_trace_fetch_complete,

            ]);

            $this->calculate($reportdate);
        }

        return $insertedcount;
    }

    private function mapTraceToDBFields($day_offset, $traceItem)
    {

        $trace = [];
        $trace['aadhaarid'] = $traceItem['emp_id'];
        $trace['device'] = $traceItem['device_id'];
        $trace['attendance_type'] = $traceItem['attendance_type'];
        $trace['auth_status'] = $traceItem['auth_status'];
        $trace['err_code'] = $traceItem['err_code'];
        $trace['att_date'] = $traceItem['att_date'];
        $trace['att_time'] = $traceItem['att_time'];
        $trace['created_date'] = $traceItem['creation_date'];
        $trace['day_offset'] = $day_offset;

        return $trace;
        // $trace->save();
    }

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
        $allemp_punchings_existing  =  $this->getPunchingsForDay($date,  $aadhaar_ids)->groupBy('aadhaarid');

        $time_groups  = OfficeTime::all()->mapWithKeys(function (array $item, int $key) {
            return [$item['id'] => $item];
        });

        $employee_section_maps =  EmployeeService::getDesignationOfEmployeesOnDate($date,  $emp_ids);
        //for each empl, calculate

       // dd($employee_section_maps);
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
                $time_group_id = $employee_section_maps[$aadhaarid]['time_group_id'];
                //only call this if we have an employee section map
                //use upsert insetad of updateorcreate inside calculateforemployee

             //   $time_group = $time_groups[$time_group_id];

                $time_group = [
                    'fn_from' => '10:15:00',
                    'fn_to' => '13:15:00',
                    'an_from' => '14:00:00',
                    'an_to' => '17:15:00',

                ];

                $data[] = $this->calculateEmployeeDaily(
                    $date,
                    $aadhaarid,
                    $employee_id,
                    $allemp_punchingtraces_grouped,
                    $emp_new_punching_data,
                    $allemp_punchings_existing,
                    $time_group
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
                'grace_total_exceeded_one_hour', 'computer_hint'
            ]
        );

        // foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
        //     PunchingTrace::where('att_date', $date)
        //         ->where('auth_status', 'Y');
        //         ->where('aadhaarid', $aadhaarid)
        //         ->update( [ 'punching_id' =>  ] );

        //  }

        //calculate sum of extra and grace seconds for this month and update monthlyattendance table
        $data =$this->calculateMonthlyAttendance($date, $aadhaar_ids, $emp_ids, $aadhaar_to_empIds);


        return $data;
    }

    public function calculateEmployeeDaily(
        $date,
        $aadhaarid,
        $employee_id,
        $allemp_punchingtraces_grouped,
        $emp_new_punching_data,
        $allemp_punchings_existing,
        $time_group
    ) {

        $punchingtraces =  $allemp_punchingtraces_grouped->has($aadhaarid) ?
            $allemp_punchingtraces_grouped->get($aadhaarid) : null;

        $punch_count =  $punchingtraces ? count($punchingtraces) : 0;



        $emp_new_punching_data['punching_count'] = $punch_count;

        $punching_existing = $allemp_punchings_existing->has($aadhaarid) ?
            $allemp_punchings_existing->get($aadhaarid) : null;

        $hint = $punching_existing && $punching_existing->has('hint') &&
            $punching_existing['hint'] ? $punching_existing['hint'] : null;

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
        if ($c_punch_in && $c_punch_out) {
            //get employee time group. now assume normal
            //

            //use today's date. imagine legislation punching out next day. our flexiend is based on today
            $duration_sec = $c_punch_in->diffInSeconds($c_punch_out);
            $emp_new_punching_data['duration_sec'] = $duration_sec ;
            $emp_new_punching_data['duration_str'] = floor($duration_sec / 3600) . gmdate(":i:s", $duration_sec % 3600);


            $normal_fn_in = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['fn_from']); //10.15
            $normal_fn_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['fn_to']); //1.15

            $normal_an_in = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['an_from']); //2.00pm
            $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['an_to']); //5.15pm
            $duration_seconds_needed =  $normal_fn_in->diffInSeconds($normal_an_out);

            $c_flexi_10am = $normal_fn_in->clone()->subMinutes(15);
            $c_flexi_530pm = $normal_an_out->clone()->addMinutes(15);
            $c_flexi_1030am = $normal_fn_in->clone()->addMinutes(15);
            $c_flexi_5pm = $normal_an_out->clone()->subMinutes(15);

            $max_grace_seconds = 3600;
            //todo ooffice ends at noon or 3.00 pm


            $office_ends_at_300pm = 0;
            $office_ends_at_noon = 0;
            $can_take_casual_fn = $can_take_casual_an = true;
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

            // \Log::info( 'duration_seconds_needed:'. $duration_seconds_needed);

            $isFullDay = true;

            [$computer_hint, $grace_total_exceeded_one_hour]= $this->setHintIfPunchMoreThanOneHourLate(
                    $c_punch_in, $c_punch_out, $duration_seconds_needed, $c_flexi_10am, $c_flexi_1030am, $c_flexi_530pm, $c_flexi_5pm, $can_take_casual_fn, $can_take_casual_an);

            $emp_new_punching_data['computer_hint'] = $computer_hint;
            $emp_new_punching_data['grace_total_exceeded_one_hour'] = $grace_total_exceeded_one_hour;

            //if real hint set by so exists, use that instead of computer hint
            if( $grace_total_exceeded_one_hour > 1800 ){
                if (($can_take_casual_fn && $computer_hint == 'casual_fn') || $hint == 'casual_fn') {
                    
                    $c_flexi_10am = $normal_an_in->clone()->subMinutes(15); //2pm -15
                    //    $c_flexi_1030am = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '14:15:00');  //2pm +15
                    $duration_seconds_needed =  $normal_an_in->diffInSeconds($normal_an_out); //3.15 hour

                    $isFullDay = false;
                    //   $max_grace_seconds = 1800;
                } else
                if (($can_take_casual_an && $computer_hint == 'casual_an') || $hint == 'casual_an') {
                    $c_flexi_530pm = $normal_fn_out->clone()->addMinutes(15); //1.15 +15
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

            //probably shift. like from 6 to 9 am
            if ($computer_hint !== 'casual' || $hint != null) //if hint exists, no need to use computer hint for else
            {
                //calculate grace
                $worked_seconds_flexi = $c_start->diffInSeconds($c_end);

                if ($worked_seconds_flexi < $duration_seconds_needed) { //worked less
                    $grace_sec = (($duration_seconds_needed - $worked_seconds_flexi)/60)*60; //ignore extra seconds
                    $emp_new_punching_data['grace_sec'] =  $grace_sec;
                    $emp_new_punching_data['grace_str'] =  (int)($grace_sec/60);
                }

                if ($duration_sec > $duration_seconds_needed) {

                    $extra_sec = $duration_sec - $duration_seconds_needed;

                    $emp_new_punching_data['extra_sec'] = $extra_sec;
                    $emp_new_punching_data['extra_str'] = (int)($extra_sec/60);
                }
            } else {
                //punched, but not enough time worked or office ends and 3 pm/12pm situations
                //set grace as 0. but allow extra time as whole day's time
                $extra_sec = $duration_sec;
                $emp_new_punching_data['extra_sec'] = $extra_sec;
                $emp_new_punching_data['extra_str'] = (int)($extra_sec/60);
            }
        }
        // \Log::info($emp_new_punching_data);

        return $emp_new_punching_data;


        //extra time
    }

    public function setHintIfPunchMoreThanOneHourLate(
        $c_punch_in, $c_punch_out, $duration_seconds_needed, $c_flexi_10am,
        $c_flexi_1030am, $c_flexi_530pm, $c_flexi_5pm, $can_take_casual_fn, $can_take_casual_an)
    {

        //this function assumes that the employee has punched in and out

        $computer_hint = null;
        $grace_total_exceeded_one_hour = 0;
        $c_start = $c_punch_in->lessThan($c_flexi_10am)  ? $c_flexi_10am : $c_punch_in;
        $c_end = $c_punch_out->greaterThan($c_flexi_530pm)  ? $c_flexi_530pm : $c_punch_out;

        $worked_seconds_flexi = $c_start->diffInSeconds($c_end);

        if ($duration_seconds_needed > $worked_seconds_flexi && $worked_seconds_flexi > 0) {
            $grace_sec = (($duration_seconds_needed - $worked_seconds_flexi)/60)*60; //ignore extra seconds

            //one hour max grace check.
            if ($grace_sec > 3600) { //if exceeded by more than 30 minutes

                //see if this punch was after 11.30 am
                if ($c_punch_in->greaterThan($c_flexi_1030am->clone()->addSeconds(3600))) {
                    $computer_hint = $can_take_casual_fn ? 'casual_fn' : ($can_take_casual_an ? 'casual_an' : 'casual');
                } else if ($c_punch_out->lessThan($c_flexi_5pm->clone()->subSeconds(3600))) {
                    $computer_hint = $can_take_casual_an ? 'casual_an' : ($can_take_casual_fn ? 'casual_fn' : 'casual');
                } else {
                    //10.08 to 4.05
                    //find which end has more has more time diff. morning or evening
                    $morning_diff = $c_flexi_1030am->diffInSeconds($c_punch_in);
                    $evening_diff = $c_punch_out->diffInSeconds($c_flexi_5pm);
                    if($morning_diff > $evening_diff)
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


    public function calculateMonthlyAttendance( $date, $aadhaar_ids = null, $aadhaar_to_empIds = null)

    {
        $start_date = Carbon::createFromFormat('Y-m-d', $date)->startOfMonth();
        $end_date = Carbon::createFromFormat('Y-m-d', $date)->endOfMonth();

        if( $aadhaar_ids == null ){
            $all_punchingtraces =  $this->getPunchingTracesForPeriod($start_date, $end_date, $aadhaar_ids);
            $aadhaar_ids  = $all_punchingtraces->pluck('aadhaarid');
        }

        // $emps = Employee::where('status', 'active')->where('has_punching', 1)->get();
        //if( $aadhaar_to_empIds == null)
        {
            $emps = Employee::wherein('aadhaarid', $aadhaar_ids)->get();
            $aadhaar_to_empIds = $emps->pluck('id', 'aadhaarid');
        }

        $punchings = Punching::whereBetween('date', [$start_date, $end_date])
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
            $emp_new_monthly_attendance_data['cl_taken'] = 0 ;
            $emp_new_monthly_attendance_data['total_grace_exceeded300_date'] = null;

            \Log::info('aadhaarid:' . $aadhaarid);
            if( $emp_punchings){
                $emp_new_monthly_attendance_data['total_grace_sec'] = $emp_punchings->sum('grace_sec');
                $emp_new_monthly_attendance_data['total_extra_sec'] = $emp_punchings->sum('extra_sec');
                $total_half_day_fn =  $emp_punchings->Where('hint', 'casual_fn')->count();
                $total_half_day_an =  $emp_punchings->where('hint', 'casual_an')->count();
                $total_full_day =  $emp_punchings->where('hint', 'casual')->count();
                $total_cl =   ($total_half_day_fn +  $total_half_day_an)/(float)2 + $total_full_day;
                $emp_new_monthly_attendance_data['cl_taken'] = $total_cl ;

                //find the day on which total grace time exceeded 300 minutes
                $total_grace = 0;
                $date = $start_date->clone();
                $total_grace_till_this_date = 0;
                for ($i = 1; $i <= $start_date->daysInMonth; $i++) {
                    $d = $date->day($i);
                    $d_str = $d->format('Y-m-d');
                    $total_grace_till_this_date += $emp_punchings->where('date', $d_str)->first()?->grace_sec ?? 0;
                    \Log::info('total_grace_till_this_date:' . $total_grace_till_this_date);
                    if ($total_grace_till_this_date > 300*60) {
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
                'total_grace_sec',  'total_extra_sec', 'cl_taken','employee_id',
                'total_grace_exceeded300_date'
            ]
        );

        return   $data;

    }

}
