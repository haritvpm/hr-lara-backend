<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\GovtCalendar;
use App\Models\PunchingTrace;
use App\Services\PunchingCalcService;

class LeaveFetchService
{

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    public function fetchLeave($fetchdate = null)
    {
        $apikey =  env('AEBAS_KEY');
        \Log::info('apike-' . $apikey );


        $offset = 0;
        $count = 500; //make it to 500 in prod

        // should be in format 2024-02-11
        $reportdate = null;
        $date = null;
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

        if ($reportdate && $date > Carbon::now()->endOfDay()) {
            \Log::info('fetchTrace - future date ignoring');
            return 0;
        }


        //check calender for this date's count.
        $offset = 0; 
        if($reportdate ){
            $govtcalender = GovtCalendar::getGovtCalender($reportdate);
            $offset = $govtcalender->leave_rows_fetched;
        } else {
            //whole items in leave
            $offset = Leaf::count();
        }

        //check last fetch time. if it less than 5 minutes, dont fetch

        $insertedcount = 0;
        for (;; $offset += $count) {

            $url = "https://basreports.attendance.gov.in/api/unibasglobal/unibasglobal/api/orgleave/offset/{$offset}/count/{$count}/apikey/{$apikey}";
            $returnkey = "leavedetails";

            if ($fetchdate && !$date->isToday()) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/orgleavebydate/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";
                $returnkey = "leavedetails";
            }
            \Log::info($url);
            $response = Http::timeout(60)->retry(3, 100)->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->get($url);


            if ($response->status() !== 200) {
                \Log::error('Response for fetchAPI:' . $response->status());
                return 0;
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
                
                Leaf::insert($datatoinsert);

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
           
           // (new PunchingCalcService())->calculate($reportdate);
        }

        return $insertedcount;
    }
    /*
    
     'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'active_status',
        'leave_cat',
        'time_period',
        'created_by_id',

    */
    private function mapTraceToDBFields($day_offset, $traceItem)
    {

        $trace = [];
        $trace['aadhaarid'] = $traceItem['emp_id'];
        $trace['leave_type'] = $traceItem['leave_type'];
        $trace['start_date'] = $traceItem['start_date'];
        $trace['end_date'] = $traceItem['end_date'];
        $trace['reason'] = $traceItem['reason'];
        $trace['active_status'] = $traceItem['active_status'];
        $trace['leave_cat'] = $traceItem['leave_cat'];
        $trace['time_period'] = $traceItem['time_period'];
        $trace['created_by_id'] = $traceItem['created_by_id'];
        $trace['creation_date'] = $traceItem['creation_date'];
        $trace['last_updated'] = $traceItem['last_updated'];
        
        return $trace;
        // $trace->save();
    }

}
