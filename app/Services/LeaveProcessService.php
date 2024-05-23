<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Leaf;
use App\Models\Setting;
use App\Models\Punching;
use Carbon\CarbonPeriod;
use App\Models\CompenGranted;
use Illuminate\Support\Facades\Http;
use App\Services\PunchingCalcService;

class LeaveProcessService
{

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function processNewLeave($leave)
    {
        $punchingCalcService = new PunchingCalcService();
        //we set proceeded to 1 if start_date and end_date is less than today
        //and also if "active_status" is Y, R or C
        $leave_start_date_actual = Carbon::parse($leave->start_date);
        $leave_end_date_actual = Carbon::parse($leave->end_date);

        $leave_start_date = $leave_start_date_actual->clone();
        if ($leave_start_date->lt(Carbon::today()->startOfYear())) {
            //  $leave_start_date =  Carbon::today()->startOfYear();
        }
        $leave_end_date = $leave_end_date_actual->clone();
        if ($leave_end_date->gt(Carbon::today())) {
            // $leave_end_date = Carbon::today();
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
            $punching =  $punchings[$date_str] ?? null;
            $needs_leave_count_update = 0;
            if ($punching) {

            } else {
                $punching = new Punching();
                $punching->aadhaarid = $leave->aadhaarid;
                $punching->date = $date_str;
            }
            $needs_leave_count_update = LeaveProcessService::updatePunchingHint($punching, $leave);

            if ($needs_leave_count_update) {
                $punchingCalcService->calculateMonthlyAttendance($date_str, [$leave->aadhaarid]);
                $punchingCalcService->calculateYearlyAttendance($date_str, [$leave->aadhaarid]);
            }
        }

        // if( $leave_start_date_actual <= Carbon::today()
        //     && $leave_end_date_actual <= Carbon::today()
        //     && in_array($leave->active_status, ['Y', 'R', 'C'])) {
        //     $leave->processed = 1;
        //     $leave->save();
        // }

        $leave->processed = 1;
        $leave->save();
    }
    private static function updatePunchingHint($punching, $leave)
    {

        if ($leave->active_status === 'R' || $leave->active_status === 'C') {

            if ($punching?->leave_id == $leave->id) { //was N before. now it is R or C
                $punching->leave_id = null;
            }
        } else {
            $punching->leave_id = $leave->id;
            $punching->is_unauthorised = $punching->is_unauthorised ? -1 : 0; //to denote it was 1 to start with and later updated
        }

        //for now, just dont show pending leaves
        //if it gets rejected, we need to update punching
        if ($leave->active_status != 'Y') {
            $punching->save();
            return 1; //no need to update leave count
        }

        if ($leave->leave_type == 'CL' || $leave->leave_type == 'casual') {
            if ($leave->leave_cat == 'F') {
                $punching->hint = 'casual';
            } else {
                $punching->hint =  $leave->time_period == 'FN' ? 'casual_fn' : 'casual_an';
            }
        } else if ($leave->leave_type == 'EL' || $leave->leave_type == 'earned') {

            $punching->hint = 'earned';
        } else if ($leave->leave_type == 'MD') {

            $punching->hint = 'medical';
        } else if ($leave->leave_type == 'HP' || $leave->leave_type == 'halfpay') {

            $punching->hint = 'halfpay';
        } else if ($leave->leave_type == 'RH') {

            $punching->hint = 'restricted';
        } else if ($leave->leave_type == 'commuted') {

            $punching->hint = 'commuted';
        } else if ($leave->leave_type == 'compen' || $leave->leave_type == 'compen_for_extra') {

            $punching->hint = 'compen';
        } else {
            $punching->hint = 'other';
        }

        $punching->save();
        return 1; //need to update leave count
    }

    public static function processLeaveStatusChange(Leaf $leaf)
    {
        //find all punchings and delete leave_id

        if ($leaf->active_status === 'R' || $leaf->active_status === 'C') {

            $punchings = Punching::where('leave_id', $leaf->id)
                ->update(['leave_id' => null]);
            //delete all compen_granted
            $compensGranted = CompenGranted::where('leave_id', $leaf->id)?->delete();
        }

        $leave_start_date = Carbon::parse($leaf->start_date);
        $leave_end_date = Carbon::parse($leaf->end_date);

        $leavePeriod = CarbonPeriod::create($leave_start_date, $leave_end_date);
        $punchingCalcService = new PunchingCalcService();

        foreach ($leavePeriod as $leavedate) {
            //recalculate monthly attendance for all dates of this leave
            $punchingCalcService->calculate($leavedate->format('Y-m-d'), [$leaf->aadhaarid]);
        }

        //also update hint ?


    }

    public static function leaveAlreadyExistsForPeriod($start_date, $end_date, $aadhaarid)
    {
        $leave_start_date = Carbon::parse($start_date);
        $leave_end_date = $end_date ? Carbon::parse($end_date) : Carbon::parse($start_date);
        /*
        $leavePeriod = CarbonPeriod::create($leave_start_date, $leave_end_date);
        foreach ($leavePeriod as $leavedate) {
            //check if leave is applied for this leavedate
            $alreadyApplied = Leaf::where('employee_id', $request->employee_id)
                                ->where('start_date', '<=', $leavedate)
                                ->where('end_date', '>=', $leavedate)
                                ->wherein('active_status', ['N', 'Y'])
                                ->first();

            if( $alreadyApplied ){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Leave already applied for this date'
                    ], 400);
            }

        }
        */


        $alreadyApplied = Leaf::where(function ($query) use ($leave_start_date, $leave_end_date) {
            $query->whereBetween('start_date', [$leave_start_date, $leave_end_date])
                ->orWhereBetween('end_date', [$leave_start_date, $leave_end_date]);
        })
            ->where('aadhaarid', $aadhaarid)
            ->wherein('active_status', ['N', 'Y'])
            ->first();

        return  $alreadyApplied;
    }
}
