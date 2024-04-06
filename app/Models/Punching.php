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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const FLEXI_SELECT = [
        'yes' => 'YES',
        'no'  => 'NO',
        'na'  => 'N/A',
    ];

    protected $fillable = [
        'date',
        'employee_id',
        'duration',
        'flexi',
        'designation',
        'grace',
        'extra',
        'remarks',
        'calc_complete',
        'punchin_trace_id',
        'punchout_trace_id',
        'ot_claimed_minutes',
        'punching_status',
        'leave_id',
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
