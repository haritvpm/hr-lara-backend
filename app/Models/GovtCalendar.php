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
//        'leave_rows_fetched',
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
    public static function getGovtCalender($reportdate)
    {
        $calender = GovtCalendar::where('date', $reportdate)->first();
        if ($calender) {
            //if( $calender->attendance_today_trace_fetched)
            {
                //  \Log::info('calendear date exists-' . $reportdate);

                // $offset = $calender->attendance_today_trace_rows_fetched;
            }
        } else {
            // \Log::info('calendear date not exists-' . $reportdate);

            $calender = new GovtCalendar();
            //  $reportdate = Carbon::createFromFormat('Y-m-d', $reportdate)->format(config('app.date_format'));
            \Log::info('calendear date ncreated -' . $reportdate);
            $calender->date = $reportdate;
            //if date is sunday or second saturday of the month, set holiday
            $date = Carbon::createFromFormat('Y-m-d', $reportdate);
            if ($date->isSunday() ) {
                $calender->govtholidaystatus = 1;
            } else if ( $date->dayOfWeek == 6) {
                $month = $date->monthName;       //September
                $year= $date->format('Y');   //2022
                $second_sat = Carbon::parse("Second saturday of {$month} {$year}");
                if($date->eq($second_sat)){
                    $calender->govtholidaystatus = 1;
                }
            }
            //$calender->attendance_today_trace_fetched = 0;
            $calender->attendance_today_trace_rows_fetched = 0;
            //$calender->success_attendance_fetched = 0;
            $calender->success_attendance_rows_fetched = 0;
            $calender->save();
        }
        return  $calender;
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
            $calender_info['day' . $i]['day'] = 'day' . $i;
            $calender_info['day' . $i]['holiday'] = $calender[$d_str]->govtholidaystatus ?? false;
            $calender_info['day' . $i]['rh'] = $calender[$d_str]->restrictedholidaystatus ?? false;
            $calender_info['day' . $i]['office_ends_at'] = $calender[$d_str]->office_ends_at ?? '';
            $calender_info['day' . $i]['future_date'] = $d->gt(Carbon::now());
            $calender_info['day' . $i]['is_today'] = $d->isToday();
            $calender_info['day' . $i]['attendance_trace_fetch_complete'] = $calender[$d_str]->attendance_trace_fetch_complete ?? false;
        }
        return $calender_info;
    }
    public static function getCalenderInfoForDate($date)
    {
        $date = Carbon::parse($date);
        $calender = GovtCalendar::where('date', $date)->first();
        $calender_info = [];

        $calender_info['day'] = $date->dayOfMonth();
        $calender_info['date'] = $date;
        $calender_info['holiday'] = $calender->govtholidaystatus ?? false;
        $calender_info['rh'] = $calender->restrictedholidaystatus ?? false;
        $calender_info['office_ends_at'] = $calender->office_ends_at ?? '';
        $calender_info['future_date'] = $date->gt(Carbon::now());
        $calender_info['is_today'] = $date->isToday();
        $calender_info['attendance_trace_fetch_complete'] = $calender->attendance_trace_fetch_complete ?? false;

        return $calender_info;
    }
}
