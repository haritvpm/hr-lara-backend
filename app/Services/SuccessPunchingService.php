<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\GovtCalendar;
use App\Models\SuccessPunching;
use App\Models\Calender;
use App\Models\Employee;

class SuccessPunchingService
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

        $govtcalender = GovtCalendar::getGovtCalender($reportdate);
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

        $totalrowsindb  = SuccessPunching::where('date', $reportdate)->count();

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
        // $success_punchs = Punching::where('date', $reportdate)->get();

        // foreach ($success_punchs as $dataItem) {

        //     //find employee
        //     $emp = Employee::where('aadhaarid',  $dataItem->emp_id)->first();
        //     if (!$emp) continue;
        //     $duration = "0";

        //     if ($dataItem['at_type'] == 'C') {
        //         $datein = Carbon::parse($dataItem->in_time);
        //         $dateout = Carbon::parse($dataItem->out_time);
        //         $duration = $dateout->diff($datein)->format('%H:%i:%s');
        //     }
        // }
    }

}