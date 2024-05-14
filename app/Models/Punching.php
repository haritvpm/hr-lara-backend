<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punching extends Model
{
    use HasFactory;

    public $table = 'punchings';

    protected $dates = [
        'date',
        'in_datetime',
        'out_datetime',
        'controller_set_punch_in',
        'controller_set_punch_out',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const HINT_SELECT = [
        'casual_fn'      => 'CL FN',
        'casual_an'      => 'CL AN',
        'duty'           => 'Duty',
        'earned'         => 'Earned',
        'commuted'       => 'Commuted',
        'casual'         => 'Casual',
        'compensation'   => 'Compensation',
        'comp_off'       => 'Comp off',
        'tour'           => 'Tour',
        'special_casual' => 'SPL CL',
        'dies_non'       => 'Dies Non',
        'RH'             => 'RH',
        'holiday'       =>  'Holiday',
        'maternity'     =>  'Maternity',
        'paternity'     =>  'Paternity',

    ];

    protected $fillable = [
        'date',
        'aadhaarid',
        'employee_id',
        'name',
        'designation',
        'section',
        'punchin_trace_id',
        'punchout_trace_id',
        'in_datetime',
        'out_datetime',
        'duration_sec',
        'grace_sec',
        'extra_sec',
        'duration_str',
        'grace_str',
        'extra_str',
        'punching_count',
        'leave_id',
        'remarks',
        'finalized_by_controller',
        'ot_sitting_sec',
        'ot_nonsitting_sec',
        'hint',
        'controller_set_punch_in',
        'controller_set_punch_out',
        'grace_total_exceeded_one_hour',
        'computer_hint',
        'single_punch_type',
        'single_punch_regularised_by',
        'time_group',
        'is_unauthorised',
        'duration_sec_needed',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // public function getDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setDateAttribute($value)
    // {
    //     $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function punchin_trace()
    {
        return $this->belongsTo(PunchingTrace::class, 'punchin_trace_id');
    }
    public function punchings()
    {
        return $this->hasMany(PunchingTrace::class, 'punching_id');
    }
    public function isHolidayForEmployee() {
        return $this->hint == 'RH' ;
    }

    public function punchout_trace()
    {
        return $this->belongsTo(PunchingTrace::class, 'punchout_trace_id');
    }

    public function leave()
    {
        return $this->belongsTo(Leaf::class, 'leave_id');
    }


}
