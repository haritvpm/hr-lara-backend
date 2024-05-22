<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeToFlexi extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'employee_to_flexis';

    protected $dates = [
        'with_effect_from',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'flexi_minutes',
        'with_effect_from',
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

    // public function getWithEffectFromAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setWithEffectFromAttribute($value)
    // {
    //     $this->attributes['with_effect_from'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public static function getEmployeeFlexiTime($date, $employee_id)
    {
        $flexi = EmployeeToFlexi::where('employee_id', $employee_id)->whereDate('with_effect_from', '<=', $date)->orderBy('with_effect_from', 'desc')->first();
        return $flexi;
    }
    public static function getAllFlexiTimes($date)
    {
        $flexi = EmployeeToFlexi::whereDate('with_effect_from', '<=', $date)->orderBy('with_effect_from', 'desc')->get();
        return $flexi;
    }

}