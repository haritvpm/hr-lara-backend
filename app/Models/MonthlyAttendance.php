<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyAttendance extends Model
{
    use HasFactory;

    public $table = 'monthly_attendances';

    protected $dates = [
        'month',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'aadhaarid',
        'employee_id',
        'month',
        'cl_taken',
        'compen_taken',
        'compoff_granted',
        'total_grace_sec',
        'total_extra_sec',
        'total_grace_str',
        'total_extra_str',
        'grace_exceeded_sec',
        'total_grace_exceeded300_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getMonthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public static function forEmployeesInMonth($date, $aadhaarids)
    {
        return MonthlyAttendance::where('month', $date->startOfMonth()->format('Y-m-d'))
        ->wherein('aadhaarid', $aadhaarids)
        ->get()->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

    }
    public static function forEmployeeInMonth($date, $aadhaarid)
    {
        return MonthlyAttendance::where('month', $date->startOfMonth()->format('Y-m-d'))
        ->where('aadhaarid', $aadhaarid)
        ->get()->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

    }

}
