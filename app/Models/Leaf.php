<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leaf extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'leaves';

    public const LEAVE_CAT_SELECT = [
        'H' => 'H',
        'F' => 'F',
    ];

    public const TIME_PERIOD_SELECT = [
        'FN' => 'FN',
        'AN' => 'AN',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'last_updated',
        'creation_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const LEAVE_TYPE_SELECT = [
        'CASUAL'       => 'CASUAL',
        'COMPEN_LEAVE' => 'COMPEN_LEAVE',
        'COMPEN_OFF'   => 'COMPEN_OFF',
        'slot1'        => 'slot1',
        'slot2'        => 'slot2',
        'COMMUTED'     => 'COMMUTED',
        'EARNED'       => 'EARNED',
        'HALFPAY'      => 'HALFPAY',
        'DUTY_OFF'     => 'DUTY_OFF',
        'SPECIAL_CL'   => 'SPECIAL_CL',
        'MATERNITY'    => 'MATERNITY',
        'PATERNITY'    => 'PATERNITY',
        'LWA'          => 'LWA',
    ];

    protected $fillable = [
        'is_aebas_leave',
        'aadhaarid',
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'active_status',
        'leave_cat',
        'time_period',
        'last_updated',
        'creation_date',
        'created_by_aadhaarid',
        'processed',
        'owner_seat',
        'remarks',
        'start_date_type',
        'end_date_type',
        'created_at',
        'updated_at',
        'deleted_at',
        'leave_count',
        'owner_can_approve',
        'forwarded_by_seat',
        'approver_employee_id',
        'approver_details',
        'approved_on',
       // 'prefix',
       // 'suffix',
       // 'date_of_joining',
    ];
    // protected function serializeDate(DateTimeInterface $date)
    // {
    //     return $date->format('Y-m-d H:i:s');
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function compensGranted()
    {
        return $this->hasMany(CompenGranted::class, 'leave_id');
    }
     public function leaveform()
    {
        return $this->hasOne(LeaveFormDetail::class, 'leave_id');
    }

    public static function getEmployeeCasualLeaves($aadhaarid, $start_date)
    {


        $c_start_date = Carbon::parse($start_date)->startOfYear();
/*        $leave_start_date = $c_start_date->format('Y-m-d');
        $leave_end_date = Carbon::parse($start_date)->endOfYear()->format('Y-m-d');

        $cls_year = Leaf::where(function ($query) use ($leave_start_date, $leave_end_date) {
                $query->whereBetween('start_date', [$leave_start_date, $leave_end_date])
                    ->orWhereBetween('end_date', [$leave_start_date, $leave_end_date]);
            })
            ->where('aadhaarid', $aadhaarid)
            ->where( 'leave_type', 'casual' )
            ->wherein('active_status', ['N', 'Y'])
            ->sum('leave_count');
            count halfs=day and 'CL'
*/
        //also get startwith leave
        \Log::info($aadhaarid);

        $yearly = YearlyAttendance::forEmployeeInYear($c_start_date, $aadhaarid);
        \Log::info('yearly');
        \Log::info($yearly);
        if( !$yearly){
            return 0;
        }
        $cls_year = $yearly?->cl_submitted ?? 0;
        $cls_startwith = $yearly?->start_with_cl ?? 0;

        return (float)$cls_year + (float)$cls_startwith;

    }
    public static function getEmployeeCompenLeaves($aadhaarid, $start_date)
    {

        //$employee = Employee::where('aadhaarid', $aadhaarid)->first();
        $c_start_date = Carbon::parse($start_date)->startOfYear();

        /*$leave_start_date = Carbon::parse($start_date)->startOfYear()->format('Y-m-d');

        $leave_end_date = Carbon::parse($start_date)->endOfYear()->format('Y-m-d');

        $co_year = Leaf::where(function ($query) use ($leave_start_date, $leave_end_date) {
                $query->whereBetween('start_date', [$leave_start_date, $leave_end_date])
                    ->orWhereBetween('end_date', [$leave_start_date, $leave_end_date]);
            })
            ->where('aadhaarid', $aadhaarid)
            ->where( function ($query) use ($leave_start_date, $leave_end_date) {
                $query->where('leave_type', 'compen')
                    ->orWhere('leave_type', 'compen_for_extra');
            })
            ->wherein('active_status', ['N', 'Y'])
            ->sum('leave_count');

       $co_startwith = YearlyAttendance::forEmployeeInYear($leave_start_date, $aadhaarid)->first()?->start_with_compen ?? 0;

        return $co_year + $co_startwith;
        */
        $yearly = YearlyAttendance::forEmployeeInYear($c_start_date, $aadhaarid);
        if( !$yearly){
            return 0;
        }
        $co_year = $yearly?->compen_submitted ?? 0;
        $co_startwith = $yearly?->start_with_compen ?? 0;

        return $co_year + $co_startwith;
    }

    public static function getEmployeeLeavesForYear($aadhaarid, $start_date, $leaveTypes)
    {
        $leave_start_date = Carbon::parse($start_date)->startOfYear()->format('Y-m-d');
        $leave_end_date = Carbon::parse($start_date)->endOfYear()->format('Y-m-d');

        // $el_year = Leaf::where(function ($query) use ($leave_start_date, $leave_end_date) {
        //         $query->whereBetween('start_date', [$leave_start_date, $leave_end_date])
        //             ->orWhereBetween('end_date', [$leave_start_date, $leave_end_date]);
        //     })
        //     ->where('aadhaarid', $aadhaarid)
        //     ->wherein('leave_type', $leaveTypes)
        //     ->wherein('active_status', ['N', 'Y'])
        //     ->sum('leave_count');
        // //$el_startwith = YearlyAttendance::forEmployeeInYear($leave_start_date, $aadhaarid)->first()?->start_with_el ?? 0;
        // return $el_year;

        $leaves = Punching::with('leave')->where('aadhaarid', $aadhaarid)
            ->whereDate('date', '>=', $leave_start_date)
            ->whereDate('date', '<=', $leave_end_date)
            ->whereHas('leave', function ($query) use ($leaveTypes) {
                $query->whereIn('leave_type', $leaveTypes)
                ->wherein('active_status', ['N', 'Y']);
            })->count();

        return $leaves;

    }

    public static function getEmployeeLeaves( $aadhaarid)
    {
        $emp_leaves = Leaf::with(['compensGranted', 'leaveform'])->where('aadhaarid', $aadhaarid)
        ->orderBy('creation_date', 'desc')
        ->get()->transform(function ($leaf) {

            $compensGranted = CompenGranted::where('leave_id', $leaf->id)->get();
            $inLieofDates = [];
            $inLieofMonth = null;
            if( $leaf->leave_type == 'compen'){
                $inLieofDates = $compensGranted->map(function($item){
                    return $item->date_of_work;
                });
            } else  if( $leaf->leave_type == 'compen_for_extra'){
                $inLieofMonth = $compensGranted->first()->date_of_work;
            }
            return [
                ...$leaf->toArray(),
                'inLieofDates' => $inLieofDates,
                'inLieofMonth' => $inLieofMonth,
            ];
        });

        return $emp_leaves;
    }


    // public function getStartDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setStartDateAttribute($value)
    // {
    //     $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getEndDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setEndDateAttribute($value)
    // {
    //     $this->attributes['end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

   // public function created_by()
   // {
   //     return $this->belongsTo(Employee::class, 'created_by_id');
   // }

    // public function getInLieuOfAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setInLieuOfAttribute($value)
    // {
    //     $this->attributes['in_lieu_of'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public static function CheckContinuousCasualLeaves($aadhaarid, $start_date, $end_date)
    {


        $c_startDate = Carbon::parse($start_date);

        //find continuous leaves before startdate
        $left = 0;
        for( $i = 1; $i <= 20; $i++){
            $prev_date = $c_startDate->clone()->subDays($i);
\Log::info($prev_date->format('Y-m-d'));
            $isHoliday = GovtCalendar::isHolidayForEmployee($prev_date->format('Y-m-d'), $aadhaarid);

            if( $isHoliday){
                continue;
            }

            $hasleaveforThisDay = Leaf::where('aadhaarid', $aadhaarid)
                ->whereDate('start_date', '<=' , $prev_date->format('Y-m-d'))
                ->whereDate('end_date', '>=' , $prev_date->format('Y-m-d'))
                ->wherein('leave_type', ['casual', 'compen', 'compen_for_extra'])
                ->wherein('active_status', ['N', 'Y'])
                ->first();

            if( $hasleaveforThisDay){

                \Log::info($hasleaveforThisDay->id);
                //make sure this is no casual_fn which means allowed
                if( $hasleaveforThisDay->leave_type == 'casual' && $hasleaveforThisDay->leave_count === 0.5){
                   if($hasleaveforThisDay->time_period === 'FN'){ //was present in evening
                    $left += 0.5;
                   }
                   break;
                }

                $left++;
            } else {
                break;
            }

        }

        \Log::info('left' . $left);

        $c_endDate = $end_date ? Carbon::parse($end_date) : Carbon::parse($start_date);
        $right = 0;
        for( $i = 1; $i <= 20; $i++){
            $next_date = $c_endDate->clone()->addDays($i);

            $calender = GovtCalendar::where('date', $prev_date->format('Y-m-d'))->first();
            if( !$calender){
                break;
            }
            if( $calender && $calender->govtholidaystatus == 1){
                continue;
            }

            $hasleaveforThisDay = Leaf::where('aadhaarid', $aadhaarid)
                ->whereDate('start_date', '<=' , $next_date->format('Y-m-d'))
                ->whereDate('end_date', '>=' , $next_date->format('Y-m-d'))
                ->wherein('leave_type', ['casual', 'compen', 'compen_for_extra'])
                ->wherein('active_status', ['N', 'Y'])
                ->first();
            if( $hasleaveforThisDay){
                if( $hasleaveforThisDay->leave_type == 'casual' && $hasleaveforThisDay->leave_count == 0.5 ){
                    if($hasleaveforThisDay->time_period === 'AN'){ //was present in morning. so add 0.5
                        $right += 0.5;
                    }
                    break;
                 }

                $right++;
            } else {
                break;
            }

        }


         return [$left,$right] ;
    }

    public static function verifyDatesAndLeaveTypes( $aadhaarid,  $dates,
                        $allowedleaveTypes, $disallowedleaveTypes)
    {

        [$leftWorking, $rightWorking] =  $dates;

        //$disallowed = [];
        foreach( $dates as $date){
            $hasleaveforThisDay = Leaf::where('aadhaarid', $aadhaarid)
                ->whereDate('start_date', '<=' , $date)
                ->whereDate('end_date', '>=' , $date)
                ->when($allowedleaveTypes, function ($query, $allowedleaveTypes) {
                    return $query->whereNotIn('leave_type', $allowedleaveTypes);
                })
                ->when($disallowedleaveTypes, function ($query, $disallowedleaveTypes) {
                    return $query->whereIn('leave_type', $disallowedleaveTypes);
                })
                ->wherein('active_status', ['N', 'Y'])
                ->first();

            if( $hasleaveforThisDay){

                if($date == $leftWorking){
                    if( $hasleaveforThisDay->leave_type == 'casual' && $hasleaveforThisDay->time_period === 'AN'){
                        return true;
                    }
                }
                else
                if($date == $rightWorking){
                    if( $hasleaveforThisDay->leave_type == 'casual' && $hasleaveforThisDay->time_period === 'FN'){
                        return true;
                    }
                }
                else {
                    return true;
                }
            }
        }
        return false;
    }

}
