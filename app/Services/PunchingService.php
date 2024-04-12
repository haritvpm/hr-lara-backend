<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Auth;
use App\Models\GovtCalendar;
use App\Models\PunchingTrace;
use App\Models\SuccessPunching;
use App\Models\Calender;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
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
            /*
        'date',
        'employee_id',
        'punchin_id',
        'duration',
        'flexi',
        'grace_min',
        'extra_min',
    */
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
                \Log::info('calendear date exists-' . $reportdate);

                // $offset = $calender->attendance_today_trace_rows_fetched;
            }
        } else {
            \Log::info('calendear date not exists-' . $reportdate);

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
        $trace['day_offset'] = $day_offset;

        return $trace;
        // $trace->save();
    }

    public function calculate($date, $emp_ids = null)
    {
        $query = PunchingTrace::where('att_date', $date)
            ->where('auth_status', 'Y');

        $query->when($emp_ids, function ($q) use ($emp_ids) {
            return $q->wherein('aadhaarid', $emp_ids);
        });

        $punchingtraces_ungrouped = $query->orderBy('created_at', 'asc')->get();
        $punchingtraces = $punchingtraces_ungrouped->groupBy('aadhaarid');
        $aadhaar_to_empIds = [];
        if($emp_ids == null) {
            $emps = Employee::wherein('aadhaarid', $punchingtraces_ungrouped->pluck('aadhaarid'))->get();
            $aadhaar_to_empIds = $emps->pluck('id','aadhaarid');
            $emp_ids = $emps->pluck('id');
        } else {
            $emps = Employee::wherein('id', $emp_ids)->get();
            $aadhaar_to_empIds = $emps->pluck('id','aadhaarid');
        }

//       dd($aadhaar_to_empIds);

        $data = [];
/*

        'employee_id',
        'designation',
        'section',
        
        
*/
        $date_str = $date;//->format('Y-m-d');

        $employee_section_maps = EmployeeToSection::during($date_str)
        ->with(['employee', 'attendance_book', 'section',])
        ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_str) {

            $q->DesignationDuring($date_str)->with(['designation']);;
        }])
        ->wherein('employee_id', $emp_ids)
        ->get();
        
        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $x = json_decode(json_encode($item));
           
            $desig = count($x->employee->employee_employee_to_designations ) ?                         $x->employee->employee_employee_to_designations[0]->designation->designation : '';
            $section = $x->section->name;

            return [ $item['employee']['aadhaarid'] => [
                            
                'designation' => $desig,
                'section' => $section,
            ]
           ];
        });

        
      //  \Log::info('EmployeeToSection ' . $employee_section_maps);
     //   dd( $employee_section_maps);
/*
     
        foreach ($punchingtraces as $key => $punching) {

            $item = [];

            $empid = $key;
            $punch_count =  count($punching);

            $item['date'] = $date->format('Y-m-d');
            $item['aadhaarid'] = $empid;
            
            $c_punch_in = null; $c_punch_out = null;
            if( $punch_count ){
                $punch = $punching[0];
                $item['punchin_trace_id'] = $punch['id'];
                $c_punch_in = Carbon::createFromFormat('Y-m-d H:i:s',$punch['att_date'] . ' ' . $punch['att_time']);
                $item['in_datetime'] =  $c_punch_in->toDateTimeString();
            }
            if( $punch_count >= 2){
                $punch = $punching[$punch_count - 1];
                $item['punchout_trace_id'] = $punch['id'];
                $c_punch_out =  Carbon::createFromFormat('Y-m-d H:i:s', $punch['att_date'] . ' ' .$punch['att_time']);
                $item['out_datetime'] =  $c_punch_out->toDateTimeString();
            }
           
            $item['punching_count'] = $punch_count;

            if( $c_punch_in && $c_punch_out ){
                $item['duration_sec'] = $c_punch_out->diffInSeconds($c_punch_in);
                $c_flexi_start = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . '10:00:00' );
                $c_flexi_end = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . '17:30:00' );

                $c_start = $c_punch_in->lessThan($c_flexi_start) ? $c_flexi_start : $c_punch_in;
                $c_end = $c_punch_out->greaterThan($c_flexi_end) ? $c_flexi_end : $c_end;

                //calculate grace
                
                $worked_minutes_flexi = $c_end->diffInMinutes($c_start);
                if( $worked_minutes_flexi < (7 * 60) ){
                    $item['grace_sec'] = (7 * 60) - $worked_minutes_flexi ;
                } else if ( $worked_minutes_flexi > (7 * 60) ) {
                    $item['extra_sec'] = $worked_minutes_flexi - (7 * 60) ;
                }

                //extra time 
                
            }

            //get employee time group. now assume normal


            $data[] = $item;
        }
*/


        return $data;
    }
}
