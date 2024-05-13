<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyAttendance extends Model
{
    use HasFactory;

    public $table = 'yearly_attendances';

    protected $dates = [
        'year',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'aadhaarid',
        'employee_id',
        'year',
        'cl_marked',
        'cl_submitted',
        'compen_marked',
        'compen_submitted',
        'other_leaves_marked',
        'other_leaves_submitted',
        'start_with_cl',
        'start_with_compen',
        'single_punchings',
        'single_punchings_regularised',
        'unauthorised_count',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // protected function serializeDate(DateTimeInterface $date)
    // {
    //     return $date->format('Y-m-d H:i:s');
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // public function getYearAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setYearAttribute($value)
    // {
    //     $this->attributes['year'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public static function forEmployeesInYear($date, $aadhaarids)
    {
        return YearlyAttendance::where('year', $date->clone()->startOfYear()->format('Y-m-d'))
        ->wherein('aadhaarid', $aadhaarids)
        ->get()->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

    }
    public static function forEmployeeInYear($date, $aadhaarid)
    {
        return YearlyAttendance::where('year', $date->clone()->startOfYear()->format('Y-m-d'))
        ->where('aadhaarid', $aadhaarid)
        ->first();

    }

    protected $appends = ['year_number'];
    public function getYearNumberAttribute()
    {
         $year_number = Carbon::parse($this->month)->format('Y');
        return $year_number;
    }
}
