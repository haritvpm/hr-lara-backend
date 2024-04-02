<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $table = 'employees';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const SRISMT_SELECT = [
        'Sri' => 'Sri',
        'Smt' => 'Smt',
        'Kum' => 'Kum',
    ];

    public const EMPLOYEE_TYPE_SELECT = [
        'contract'  => 'Contract',
        'permanent' => 'Permanent',
        'dailywage' => 'DailyWage',
        'temporary' => 'Temporary',
    ];

    protected $fillable = [
        'srismt',
        'name',
        'name_mal',
        'pen',
        'aadhaarid',
        'employee_type',
        'desig_display',
        'pan',
        'has_punching',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function employeeEmployeeToDesignations()
    {
        return $this->hasMany(EmployeeToDesignation::class, 'employee_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(EmployeeStatus::class, 'status_id');
    }
}
