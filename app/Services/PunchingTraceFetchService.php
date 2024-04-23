<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\GovtCalendar;
use App\Models\PunchingTrace;
use App\Services\PunchingCalcService;

class PunchingTraceFetchService
{

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
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

        $govtcalender = GovtCalendar::getGovtCalender($reportdate);
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

            (new PunchingCalcService())->calculate($reportdate);
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

}
