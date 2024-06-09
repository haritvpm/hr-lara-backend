<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyPostingForm extends Model
{
    use HasFactory;

    public $table = 'duty_posting_forms';

    public const TYPE_SELECT = [
        'ot'   => 'ot',
        'duty' => 'duty',
    ];

    protected $dates = [
        'period_from',
        'period_to',
        'approved_on',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_by_seat_id',
        'created_by_detail',
        'owner_seat_id',
        'approver_seat_id',
        'approver_detail',
        'period_from',
        'period_to',
        'forwarder_details',
        'approved_on',
        'type',
        'reason',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function created_by_seat()
    {
        return $this->belongsTo(Seat::class, 'created_by_seat_id');
    }

    public function owner_seat()
    {
        return $this->belongsTo(Seat::class, 'owner_seat_id');
    }

    public function approver_seat()
    {
        return $this->belongsTo(Seat::class, 'approver_seat_id');
    }

    public function getPeriodFromAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setPeriodFromAttribute($value)
    {
        $this->attributes['period_from'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPeriodToAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setPeriodToAttribute($value)
    {
        $this->attributes['period_to'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getApprovedOnAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setApprovedOnAttribute($value)
    {
        $this->attributes['approved_on'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
