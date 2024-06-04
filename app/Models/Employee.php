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
        'has_punching',
        'status',
        'is_shift',
        'grace_group_id',
        'leave_group_id',
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
        //get the current designation of the employee
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
    public static function getEmployeesWithAadhaarDesig( $activeOnly=null, $whereidnotin = null, $plain=true)
    {
        $employees = Employee::with('designation')
            ->when($whereidnotin, function ($query) use ($whereidnotin) {
                return $query->whereNotIn('id', $whereidnotin);
            })
            ->when($activeOnly, function ($query) {
                return $query->where(fn ($query) => $query->where('status', 'active')->orWherenull('status'));
            })
            ->orderBy('name')
            ->get();

            if($plain){
                $employees = $employees->mapWithKeys(function ($employee) {
                $desig = $employee?->designation?->first()?->designation->designation;
               // dd($employee->designation);
                return [$employee->id   =>  $employee->name .'-' .$employee->aadhaarid . ($desig ? ' - ' . $desig : '')];
                });
            } else {
                $employees = $employees->map(function ($employee) {
                    $desig = $employee?->designation?->first()?->designation->designation;
                   // dd($employee->designation);
                    return [ 'id' => $employee->id, 'name' => "{$employee->aadhaarid} - {$employee->name} ({$desig})"];
                    });
            }

         return $employees;
    }
    public function seniority()
    {
        return $this->hasOne(Seniority::class, 'employee_id');
    }
    public function employeeExtra()
    {
        return $this->hasOne(EmployeeExtra::class, 'employee_id');
    }
      public function grace_group()
    {
        return $this->belongsTo(GraceTime::class, 'grace_group_id');
    }
     public function employeeCompenGranteds()
    {
        return $this->hasMany(CompenGranted::class, 'employee_id', 'id');
    }
     public function leave_group()
    {
        return $this->belongsTo(LeaveGroup::class, 'leave_group_id');
    }
    public function employeeSectionMapping()
    {
        return $this->hasMany(EmployeeToSection::class, 'employee_id', 'id');
    }
}
