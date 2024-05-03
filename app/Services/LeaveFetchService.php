<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\GovtCalendar;
use App\Models\Leaf;
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


        //check last fetch time. if it less than 5 minutes, dont fetch

        $insertedcount = 0;
        for (;; $offset += $count) {

            $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/orgleave/offset/{$offset}/count/{$count}/apikey/{$apikey}";
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
            $newOrUpdatedLeaves = [];
            for ($i = 0; $i < count($jsonData); $i++) {
                //ignore errors
                
                    $item = $this->mapTraceToDBFields($offset + $i, $jsonData[$i]);

                    //check if there is a change in active_status. if so, note the aadharrid
                    $existingrow = Leaf::where('aadhaarid', $item['aadhaarid'])
                        ->where('creation_date', $item['creation_date'])
                        ->first();

                    if( $existingrow){
                        if($existingrow->active_status != $item['active_status'] ||
                            $existingrow->leave_type != $item['leave_type'] ||
                            $existingrow->start_date != $item['start_date'] ||
                            $existingrow->end_date != $item['end_date'] ||
                            $existingrow->last_updated != $item['last_updated'] ||
                            $existingrow->time_period != $item['time_period']){

                            $newOrUpdatedLeaves[] = $item;
                            }
                    } else {
                        $newOrUpdatedLeaves[] = $item;
                    }


                    $datatoinsert[] = $item;
                
            }

            $error = 0;
            try {
                //DB::transaction(function () use ($datatoinsert, $jsonData, &$error) {
                //All databases except SQL Server require the columns in the second argument of the upsert method to have a "primary" or "unique" index.
                //In addition, the MySQL database driver ignores the second argument of the upsert method and always uses the "primary" and "unique" indexes of the table to detect existing records.

                //upsert updates updated_at field of all records. so we cannot use that to find updated records

              /*  Leaf::upsert($datatoinsert, ['aadhaarid', 'creation_date' ],
                [ 'start_date','end_date',  'leave_type', 'reason', 'active_status',
                 'leave_cat', 'time_period',  'last_updated']);*/

                $insertedcount += count($jsonData);
                //  });

            } catch (Exception $e) {
                //  $error = 1;
                throw new Exception($e->getMessage());
            }

            $this->processNewAndUpdatedLeaves($newOrUpdatedLeaves);



            //if reached end of data, break
            if ($error ||  (count($jsonData) < $count)) {

                break;
            }
        }

        //upsert updates all records. so we cannot use that to find updated records
        $newLeaves = Leaf::whereDate('created_at', Carbon::today())
                            ->get();


        \Log::info('Newly created/updated rows:' . $insertedcount);
        \Log::info('Newly created/updated rows as per db :' . $newLeaves->count());

        //$totalrowsindb  = PunchingTrace::where('att_date',$reportdate)->count();

        if ($insertedcount) {

           // (new PunchingCalcService())->calculate($reportdate);
        }

        return $insertedcount;
    }

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
        $trace['created_by_aadhaarid'] = $traceItem['created_by'];
        $trace['creation_date'] = $traceItem['creation_date'];
        $trace['last_updated'] = $traceItem['last_updated'];
        if( $trace['last_updated'] == '0000-00-00 00:00:00' ){
            $trace['last_updated'] = null;
        }

        return $trace;
        // $trace->save();
    }
    //to be called every day on leave fetch. 
    //takes care of leaves submitted after date
    public function processNewAndUpdatedLeaves($newOrUpdatedLeaves)
    {
        //only process leave dates upto max one month and start of this year
        

        foreach ($newOrUpdatedLeaves as $item) {
            $leaf = Leaf::where('aadhaarid', $item['aadhaarid'])
                ->where('creation_date', $item['creation_date'])
                ->first();
            
            //for each date from $leaf->start_date  to $leaf->end_date, updateOrCreate the punching with leave_id
            
                
            $punchings = Punching::where('aadhaarid', $item['aadhaarid'])
                ->where('date', '>=', $leaf->start_date )
                ->where('date', '<=', $leaf->end_date)
                ->get();
            
            \Log::info('leave' . $leaf );

            foreach ($punchings as $punching) {
                \Log::info('punching:' . $punching->id);

                $punching->leave_id = $leaf->id;
                $punching->save();
            }

        }
    }
    //to be called on daily punching calc. this takes care of leaves submitted before date
    public function processTodayLeaves()
    {
        //autogen
        $today = Carbon::today();
        $leaves = Leaf::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        foreach ($leaves as $leaf) {
            $punchings = Punching::where('aadhaarid', $leaf->aadhaarid)
                ->where('date', $today)
                ->get();

            foreach ($punchings as $punching) {
                $punching->leave_id = $leaf->id;
                $punching->save();
            }
        }
    }
}
