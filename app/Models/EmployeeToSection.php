<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeToSection extends Model
{
    use HasFactory;

    public $table = 'employee_to_sections';

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'section_id',
        'attendance_book_id',
        'start_date',
        'end_date',
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

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function attendance_book()
    {
        return $this->belongsTo(AttendanceBook::class, 'attendance_book_id');
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

    public function scopeOnDate($query, $date)
    {
        return $query->with(['section'])->where(function ($query) use ($date) {
            $query->where('start_date', '<=', $date)
                ->where(function ($query) use ($date) {
                    $query->where('end_date', '>=', $date)
                        ->orwherenull('end_date');
                })->orderBy('start_date', 'asc');
        });
    }
    public function scopeDuringPeriod($query, $date_from, $date_to)
    {
        return $query->with('section')->where(function ($query) use ($date_from, $date_to) {
            $query->where('start_date', '<=', $date_to)
                ->where(function ($query) use ($date_from, $date_to) {
                    $query->where('end_date', '>=', $date_from)
                        ->orwherenull('end_date');
                });
        });
    }
    // public function scopeSectionNow($query)
    // {
    //     $date = Carbon::now()->toDateString();
    //     return $query->with('section')->where(function ($query) use ($date) {
    //         $query->where('start_date', '<=', $date)
    //             ->where(function ($query) use ($date) {
    //                 $query->where('end_date', '>=', $date)
    //                     ->orwherenull('end_date');
    //             });
    //     });
    // }

    // public static function getSectionsForEmployeeOnEachDayDuringPeriodMappedEachDayInPeriodToASection($employeeId, $from, $to)
    // {
    //     $dates = [];
    //     $currentDate = Carbon::parse($from);
    //     $endDate = Carbon::parse($to);

    //     while ($currentDate->lte($endDate)) {
    //         $dates[] = $currentDate->format('Y-m-d');
    //         $currentDate->addDay();
    //     }

    //     $sections = [];

    //     foreach ($dates as $date) {
    //         $section = self::duringPeriod($date, $date)
    //             ->where('employee_id', $employeeId)
    //             ->first();

    //         $sections[$date] = $section ? $section->section : null;
    //     }

    //     return $sections;
    // }


}
