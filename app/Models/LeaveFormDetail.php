<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveFormDetail extends Model
{
    use HasFactory;

    public $table = 'leave_form_details';

    protected $dates = [
        'dob',
        'doe',
       // 'date_of_confirmation',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'dob',
        'post',
        'dept',
        'pay',
        'scaleofpay',
        'doe',
        'docc',
        'confirmation_info',
        'address',
        'hra',
        'nature',
        'prefix',
        'suffix',
        'last_leave_info',
        'leave_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // public function getDobAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setDobAttribute($value)
    // {
    //     $this->attributes['dob'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getDoeAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setDoeAttribute($value)
    // {
    //     $this->attributes['doe'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getDateOfConfirmationAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setDateOfConfirmationAttribute($value)
    // {
    //     $this->attributes['date_of_confirmation'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public function leave()
    {
        return $this->belongsTo(Leaf::class, 'leave_id');
    }
}
