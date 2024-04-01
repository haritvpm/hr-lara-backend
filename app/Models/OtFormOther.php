<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtFormOther extends Model
{
    use HasFactory;

    public $table = 'ot_form_others';

    public const OVERTIME_SLOT_SELECT = [
        'First'    => 'First',
        'Second'   => 'Second',
        'Third'    => 'Third',
        'Sittings' => 'Sittings',
    ];

    protected $dates = [
        'submitted_on',
        'duty_date',
        'date_from',
        'date_to',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'creator',
        'owner',
        'session_id',
        'submitted_by',
        'submitted_on',
        'form_no',
        'duty_date',
        'date_from',
        'date_to',
        'remarks',
        'overtime_slot',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function getSubmittedOnAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setSubmittedOnAttribute($value)
    {
        $this->attributes['submitted_on'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDutyDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDutyDateAttribute($value)
    {
        $this->attributes['duty_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateFromAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateFromAttribute($value)
    {
        $this->attributes['date_from'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateToAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateToAttribute($value)
    {
        $this->attributes['date_to'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
