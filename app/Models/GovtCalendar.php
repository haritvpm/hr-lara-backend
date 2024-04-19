<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovtCalendar extends Model
{
    use HasFactory;

    public $table = 'govt_calendars';

    public const OFFICE_ENDS_AT_SELECT = [
        'noon' => 'noon',
        '3pm'  => '3 p.m.',
    ];

    protected $dates = [
        'date',
        'success_attendance_lastfetchtime',
        'attendancetodaytrace_lastfetchtime',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'govtholidaystatus',
        'restrictedholidaystatus',
        'festivallist',
        'success_attendance_lastfetchtime',
        'success_attendance_rows_fetched',
        'attendancetodaytrace_lastfetchtime',
        'attendance_today_trace_rows_fetched',
        'is_sitting_day',
        'punching',
        'session_id',
        'office_ends_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'attendance_trace_fetch_complete',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getSuccessAttendanceLastfetchtimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setSuccessAttendanceLastfetchtimeAttribute($value)
    {
        $this->attributes['success_attendance_lastfetchtime'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getAttendancetodaytraceLastfetchtimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setAttendancetodaytraceLastfetchtimeAttribute($value)
    {
        $this->attributes['attendancetodaytrace_lastfetchtime'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function session()
    {
        return $this->belongsTo(AssemblySession::class, 'session_id');
    }

    public static function getCalenderInfoForPeriod($start_date, $end_date)
    {
        $date = Carbon::parse($start_date);
        $calender = GovtCalendar::whereBetween('date', [$start_date, $end_date])->get()->mapwithKeys(function ($item) {
            return [$item['date'] => $item];
        });
        $calender_info = [];
        for ($i = 1; $i <= $date->daysInMonth; $i++) {

            $d = $date->day($i);
            $d_str = $d->format('Y-m-d');
            $calender_info['day' . $i]['holiday'] = $calender[$d_str]->govtholidaystatus ?? false;
            $calender_info['day' . $i]['rh'] = $calender[$d_str]->restrictedholidaystatus ?? false;
            $calender_info['day' . $i]['office_ends_at'] = $calender[$d_str]->office_ends_at ?? '';
            $calender_info['day' . $i]['future_date'] = $d->gt(Carbon::now());
            $calender_info['day' . $i]['is_today'] = $d->isToday();
            $calender_info['day' . $i]['attendance_trace_fetch_complete'] = $calender[$d_str]->attendance_trace_fetch_complete ?? false;
        }
        return $calender_info;
    }
}
