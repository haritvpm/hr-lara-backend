<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Leaf;
use App\Models\Punching;
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
            //$newOrUpdatedLeaves = [];
            for ($i = 0; $i < count($jsonData); $i++) {
                //ignore errors

                    $item = $this->mapTraceToDBFields($offset + $i, $jsonData[$i]);

                    //check if there is a change in active_status. if so, note the aadharrid
                    /*
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
*/

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

          //  $this->processNewAndUpdatedLeaves($newOrUpdatedLeaves);



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

    public function processLeaves()
    {
        //get chunks of 1000 leaves from Leaf table and process them
        $start_time = Carbon::now();
        $offset = 0;
        $count = 1000;
        $error = 0;
        $firstNOffset = 0;
        for (;; $offset += $count) {
            $leaves = Leaf::orderBy('creation_date', 'asc')->offset($offset)->limit($count)
            //->wherein('active_status', ['Y', 'N'])
           // ->wherenot('processed',1)

            ->get();
            if ($leaves->count() == 0) {
                break;
            }

            foreach ($leaves as $leaf) {
                if( $firstNOffset === 0 && $leaf->active_status === 'N' ){
                    $firstNOffset = $offset;
                }

                $this->processLeave($leaf);
            }

        }
        Setting::updateOrCreate(
            ['key' => 'firstNOffset'],
            ['value' => $firstNOffset]
        );
        Setting::updateOrCreate(
            ['key' => 'LastLeaveProcessed'],
            ['value' => Carbon::now()]
        );
        Setting::updateOrCreate(
            ['key' => 'LastLeaveProcessDuration'],
            ['value' => $start_time->diffInMinutes(Carbon::now())]

        );

    }
    private function processLeave($leave)
    {
        $punchingCalcService = new PunchingCalcService();
        //we set proceeded to 1 if start_date and end_date is less than today
        //and also if "active_status" is Y, R or C
        $leave_start_date_actual = Carbon::parse($leave->start_date);
        $leave_end_date_actual = Carbon::parse($leave->end_date);

        $leave_start_date = $leave_start_date_actual->clone();
        if( $leave_start_date->lt(Carbon::today()->startOfYear()) ){
            $leave_start_date =  Carbon::today()->startOfYear();
        }
        $leave_end_date = $leave_end_date_actual->clone();
        if( $leave_end_date->gt(Carbon::today())) {
            $leave_end_date = Carbon::today();
        }


        //for each date from $leaf->start_date to $leaf->end_date, updateOrCreate the Punching with leave_id
        //if Punching does not exist, create it

        $punchings = Punching::where('aadhaarid', $leave->aadhaarid)
            ->where('date', '>=', $leave_start_date)
            ->where('date', '<=',  $leave_end_date)
            ->get()->mapwithkeys(function ($item) {
                return [$item['date'] => $item];
            });

        for ($date = $leave_start_date; $date <= $leave_end_date; $date->addDay()) {
            $date_str = $date->format('Y-m-d');
            $punching =  $punchings[ $date_str] ?? null;
            $needs_leave_count_update = 0;
            if ($punching) {

                $needs_leave_count_update = $this->updatePunchingHint($punching, $leave);
            } else {
                $punching = new Punching();
                $punching->aadhaarid = $leave->aadhaarid;
                $punching->date = $date;

                $needs_leave_count_update = $this->updatePunchingHint($punching, $leave);
            }

            if( $needs_leave_count_update ){
                $punchingCalcService->calculateMonthlyAttendance($date_str, [$leave->aadhaarid]);
                $punchingCalcService->calculateYearlyAttendance ($date_str, [$leave->aadhaarid]);

            }
        }

        if( $leave_start_date_actual <= Carbon::today()
            && $leave_end_date_actual <= Carbon::today()
            && in_array($leave->active_status, ['Y', 'R', 'C'])) {
            $leave->processed = 1;
            $leave->save();
        }
    }
    private function updatePunchingHint($punching, $leave )
    {

        if( $leave->active_status === 'R' || $leave->active_status === 'C' ){

            if( $punching?->leave_id == $leave->id ){ //was N before. now it is R or C
                $punching->leave_id = null;
            }

        } else {
            $punching->leave_id = $leave->id;
        }

        //for now, just dont show pending leaves
        //if it gets rejected, we need to update punching
        if( $leave->active_status != 'Y' ){
            $punching->save();
            return 1; //no need to update leave count
        }

        if( $leave->leave_type == 'CL' ){
            if( $leave->leave_cat == 'F' ){
                $punching->hint = 'casual';
            } else {
                $punching->hint =  $leave->time_period == 'FN' ? 'casual_fn' : 'casual_an';
            }

        } else if( $leave->leave_type == 'EL' ){

             $punching->hint = 'earned';
        } else if( $leave->leave_type == 'MD' ){

            $punching->hint = 'medical';
        } else if( $leave->leave_type == 'HP' ){

            $punching->hint = 'halfpay';
        } else if( $leave->leave_type == 'RH' ){

            $punching->hint = 'restricted';
        } else {
            $punching->hint = 'other';
        }

        $punching->save();
        return 1; //need to update leave count
    }
}
