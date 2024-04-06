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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'active_status',
        'leave_cat',
        'time_period',
        'created_by_id',
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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(Employee::class, 'created_by_id');
    }
}