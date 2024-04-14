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
use App\Models\Section;
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

        for (;; $offset += $count) {

            $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendancetodaytrace/offset/{$offset}/count/{$count}/apikey/{$apikey}";
            $returnkey = "attendancetodaytrace";

            if ($fetchdate && !$date->isToday()) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/trace/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";
                $returnkey = "attendancetrace";
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
                'attendancetodaytrace_lastfetchtime' => Carbon::now() //today

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
        $trace['creation_date'] = $traceItem['creation_date'];
        $trace['day_offset'] = $day_offset;

        return $trace;
        // $trace->save();
    }

    public function getEmployeeSectionMappingsAndDesignations($date_str,  $emp_ids)
    {
        $employee_section_maps = EmployeeToSection::during($date_str)
            ->with(['employee', 'attendance_book', 'section',])
            ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_str) {

                $q->DesignationDuring($date_str)->with(['designation']);;
            }])
            ->wherein('employee_id', $emp_ids)
            ->get();

        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $x = json_decode(json_encode($item));

            $desig = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->designation : '';
            $section = $x->section->name;
            $time_group_id = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->default_time_group_id : null;

            return [
                $item['employee']['aadhaarid'] => [
                    'designation' => $desig,
                    'section' => $section,
                    'shift' => $x->employee?->is_shift,
                    'time_group_id' => $time_group_id,
                ]
            ];
        });

        return $employee_section_maps;
    }
    public function getPunchingTracesForDay($date,  $aadhaar_ids)
    {
        $query = PunchingTrace::where('att_date', $date)
            ->where('auth_status', 'Y');
        $query->when($aadhaar_ids, function ($q) use ($aadhaar_ids) {
            return $q->wherein('aadhaarid', $aadhaar_ids);
        });
        return $query->orderBy('creation_date', 'asc')->get();
    }
    public function getPunchingsForDay($date,  $aadhaar_ids)
    {
        return Punching::where('att_date', $date)
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

        $employee_section_maps =  $this->getEmployeeSectionMappingsAndDesignations($date,  $emp_ids);
        //for each empl, calculate

        foreach ($aadhaar_to_empIds as $aadhaarid => $employee_id) {
            $emp_new_punching_data = [];
            $emp_new_punching_data['date'] = $date;
            $emp_new_punching_data['aadhaarid'] = $aadhaarid;
            $emp_new_punching_data['employee_id'] = $employee_id;
            //this employee might not have been mapped to a section
            if ($employee_section_maps->has($aadhaarid)) {
                $emp_new_punching_data['designation'] = $employee_section_maps[$aadhaarid]['designation'];
                $emp_new_punching_data['section'] = $employee_section_maps[$aadhaarid]['section'];
                $emp_new_punching_data['shift'] = $employee_section_maps[$aadhaarid]['shift'];
                $emp_new_punching_data['designation'] = $employee_section_maps[$aadhaarid]['designation'];
                $emp_new_punching_data['section'] = $employee_section_maps[$aadhaarid]['section'];
                $emp_new_punching_data['time_group_id'] = $employee_section_maps[$aadhaarid]['time_group_id'];
            }

            $this->calculateForEmployee(
                $date,
                $aadhaarid,
                $employee_id,
                $allemp_punchingtraces_grouped,
                $emp_new_punching_data,
                $allemp_punchings_existing,
                $time_groups
            );
        }
    }

    public function calculateForEmployee(
        $date,
        $aadhaarid,
        $employee_id,
        $allemp_punchingtraces_grouped,
        $emp_new_punching_data,
        $allemp_punchings_existing,
        $time_groups
    ) {

        $punchingtraces =  $allemp_punchingtraces_grouped->has($aadhaarid) ?
            $allemp_punchingtraces_grouped->get($aadhaarid) : null;

        $punch_count =  $punchingtraces ? count($punchingtraces) : 0;

        $emp_new_punching_data['punching_count'] = $punch_count;

        $punchings_existing = $allemp_punchings_existing->has($aadhaarid) ?
            $allemp_punchings_existing->get($aadhaarid) : null;

        $c_punch_in = null;
        $c_punch_out = null;
        if ($punch_count) {
        }
        if ($punch_count  == 1) {
            //sync
            //TODO is it punch in or out ? has to be set by under
        }
        if ($punch_count >= 2) {

            $punch = $punchingtraces[0];
            // $emp_new_punching_data['punchin_created'] =$punch['created_at']->format('Y-m-d H:i:s');
            $emp_new_punching_data['punchin_offset'] = $punch['day_offset'];
            $emp_new_punching_data['punchin_trace_id'] = $punch['id'];
            $c_punch_in = Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $emp_new_punching_data['in_datetime'] =  $c_punch_in->toDateTimeString();

            $punch = $punchingtraces[$punch_count - 1];
            $emp_new_punching_data['punchout_trace_id'] = $punch['id'];
            // $emp_new_punching_data['punchout_created'] =$punch['created_at']->format('Y-m-d H:i:s');;
            $emp_new_punching_data['punchout_offset'] = $punch['day_offset'];
            $c_punch_out =  Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' . $punch['att_time']);
            $emp_new_punching_data['out_datetime'] =  $c_punch_out->toDateTimeString();
        }


        if ($c_punch_in && $c_punch_out) {
            //get employee time group. now assume normal
            $time_group = $time_groups[$emp_new_punching_data['time_group_id']];
            //use today's date. imagine legislation punching out next day. our flexiend is based on today

            $emp_new_punching_data['duration_sec'] = $c_punch_out->diffInSeconds($c_punch_in);

          //  $c_flexi_1030am = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '10:30:00');
          //  $c_flexi_5pm = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '17:00:00');
            $normal_fn_in = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['fn_from']); //10.15
            $normal_fn_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['fn_to']); //1.15

            $normal_an_in = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['an_from']); //2.00pm
            $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' .  $time_group['an_to']);//5.15pm

            $c_flexi_10am = $normal_fn_in->subMinutes(15);
            $c_flexi_530pm = $normal_an_out->addMinutes(15);

            $max_grace_seconds = 3600;

            //office ends 3.00 or at noon.
            $office_ends_at_300pm=0;
            if($office_ends_at_300pm){
                //todo no casual in the eve
                $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '15:00:00');//
                $max_grace_seconds = 1800; // ?
            }

            $duration_seconds_needed =  $normal_an_out->diffInSeconds($normal_fn_in);

            $isFullDay = true;
            if ($punchings_existing && $punchings_existing['hint'] == 'casual_fn') {
                $c_flexi_10am = $normal_an_in->subMinutes(15); //2pm -15
            //    $c_flexi_1030am = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '14:15:00');  //2pm +15
                $duration_seconds_needed =  $normal_an_out->diffInSeconds($normal_an_in); //3.15 hour
                $isFullDay = false;
                $max_grace_seconds = 1800;
            }
            else
            if ($punchings_existing && $punchings_existing['hint'] == 'casual_an') {
                $c_flexi_530pm = $normal_fn_out->addMinutes(15); //1.15 +15
              //  $c_flexi_5pm = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . '13:00:00'); //1.15 - 15
                //$duration_seconds_needed = 3 * 3600;
                $duration_seconds_needed =  $normal_fn_out->diffInSeconds($normal_fn_in); //3.00 hour
                $isFullDay = false;
                $max_grace_seconds = 1800;
            }



            //if punches in before 10 am or punches out after 5.30, dont take that, use 10am and 5.30
            $c_start = $c_punch_in->lessThan($c_flexi_10am)  ? $c_flexi_10am : $c_punch_in;
            $c_end = $c_punch_out->greaterThan($c_flexi_530pm)  ? $c_flexi_530pm : $c_punch_out;

            //todo also check if office time ends early.

            //probably shift. like from 6 to 9 am
            if ($c_start->lessThan($c_punch_out) && $c_end->greaterThan($c_punch_in)) {
                //if( isCL_FN ) //todo
                //calculate grace
                $worked_seconds_flexi = $c_end->diffInSeconds($c_start);
                if ($worked_seconds_flexi < $duration_seconds_needed) { //worked less
                    $grace_sec = $duration_seconds_needed - $worked_seconds_flexi;
                    $emp_new_punching_data['grace_sec'] =  $grace_sec;

                    //one hour max grace check.
                    if ($grace_sec > $max_grace_seconds) {
                      $emp_new_punching_data['grace_total_exceeded_one_hour'] = $grace_sec - $max_grace_seconds ;
                    }

                } else if ($worked_seconds_flexi > $duration_seconds_needed) {
                    $emp_new_punching_data['extra_sec'] = ($worked_seconds_flexi - $duration_seconds_needed);
                }
            }

            Punching::updateOrCreate(
                ['date' => $emp_new_punching_data['date'], 'aadhaarid' =>  $emp_new_punching_data['aadhaarid']],
                [
                    'employee_id' => $emp_new_punching_data['employee_id'],
                    'designation' => $emp_new_punching_data['designation'],
                    'section' => $emp_new_punching_data['section'],
                    'punching_count' => $emp_new_punching_data['punching_count'],
                    'punchin_trace_id' => $emp_new_punching_data['punchin_trace_id'],
                    'punchout_trace_id' => $emp_new_punching_data['punchout_trace_id'],
                    'in_datetime' => $emp_new_punching_data['in_datetime'],
                    'out_datetime' => $emp_new_punching_data['out_datetime'],
                    'duration_sec' => $emp_new_punching_data['duration_sec'],
                    'grace_sec' => $emp_new_punching_data['grace_sec'] ?? null,
                    'extra_sec' => $emp_new_punching_data['extra_sec'] ?? null,

                ]
            );
            //extra time

        }
    }
}
