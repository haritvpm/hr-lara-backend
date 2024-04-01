<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PunchingRegister extends Model
{
    use HasFactory;

    public $table = 'punching_registers';

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
        'grace_min',
        'extra_min',
        'success_punching_id',
        'designation',
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

    public function success_punching()
    {
        return $this->belongsTo(SuccessPunching::class, 'success_punching_id');
    }

    public function punching_traces()
    {
        return $this->belongsToMany(PunchingTrace::class);
    }
}
