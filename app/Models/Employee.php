<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $table = 'employees';
    protected $appends = ['name-aadhaar'];
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

    public const STATUS_SELECT = [
        'active'   => 'active',
        'retired'  => 'retired',
        'relieved' => 'relieved',
        'onleave'  => 'onleave',
    ];

    protected $fillable = [
        'srismt',
        'name',
        'name_mal',
        'aadhaarid',
        'pen',
        'desig_display',
        'pan',
        'has_punching',
        'status',
        'is_shift',
        'klaid',
        'electionid',
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
    public function designation()
    {
        return $this->hasMany(EmployeeToDesignation::class, 'employee_id', 'id')->designationNow();
    }


    public function getNameAadhaarAttribute()
    {
        return $this->name . ' - ' . $this->aadhaarid;
    }

    public static function getEmployeesWithAadhaar()
    {
        $employees = Employee::all()
            ->mapWithKeys(function ($employee) {
                return [$employee->id   =>  $employee->name .'-' .$employee->aadhaarid];
                });

         return $employees;
    }
    public function seniority()
    {
        return $this->hasOne(Seniority::class, 'employee_id');
    }


}
