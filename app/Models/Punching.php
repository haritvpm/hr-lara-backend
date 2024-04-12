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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'aadhaarid',
        'employee_id',
        'designation',
        'section',
        'punchin_trace_id',
        'punchout_trace_id',
        'in_datetime',
        'out_datetime',
        'duration_sec',
        'grace_sec',
        'extra_sec',
        'punching_count',
        'ot_sitting_mins',
        'ot_nonsitting_mins',
        'leave_id',
        'remarks',
        'finalized_by_controller',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function punchin_trace()
    {
        return $this->belongsTo(PunchingTrace::class, 'punchin_trace_id');
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
