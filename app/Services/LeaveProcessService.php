<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Leaf;
use App\Models\Punching;
use App\Services\PunchingCalcService;

class LeaveProcessService
{

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function processLeave($leave)
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

                $needs_leave_count_update = LeaveProcessService::updatePunchingHint($punching, $leave);
            } else {
                $punching = new Punching();
                $punching->aadhaarid = $leave->aadhaarid;
                $punching->date = $date;

                $needs_leave_count_update = LeaveProcessService::updatePunchingHint($punching, $leave);
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
    private static function updatePunchingHint($punching, $leave )
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

        if( $leave->leave_type == 'CL' || $leave->leave_type == 'casual'){
            if( $leave->leave_cat == 'F' ){
                $punching->hint = 'casual';
            } else {
                $punching->hint =  $leave->time_period == 'FN' ? 'casual_fn' : 'casual_an';
            }

        } else if( $leave->leave_type == 'EL' || $leave->leave_type == 'earned'){

             $punching->hint = 'earned';
        } else if( $leave->leave_type == 'MD' ){

            $punching->hint = 'medical';
        } else if( $leave->leave_type == 'HP' || $leave->leave_type == 'halfpay'){

            $punching->hint = 'halfpay';
        } else if( $leave->leave_type == 'RH' ){

            $punching->hint = 'restricted';
        } 
        else if( $leave->leave_type == 'commuted'){

            $punching->hint = 'commuted';
        }
        else if( $leave->leave_type == 'compen' || $leave->leave_type == 'compen_for_extra'){

            $punching->hint = 'compen';
        }
        else {
            $punching->hint = 'other';
        }

        $punching->save();
        return 1; //need to update leave count
    }
}
