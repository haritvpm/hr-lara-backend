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

    public const STATUS_SELECT = [
        'retired'  => 'Retired',
        'relieved' => 'Relieved',
    ];

    public const SRISMT_SELECT = [
        'Sri' => 'Sri',
        'Smt' => 'Smt',
        'Kum' => 'Kum',
    ];

    public const EMPLOYEE_TYPE_SELECT = [
        'Contract'  => 'Contract',
        'Permanent' => 'Permanent',
        'DailyWage' => 'DailyWage',
    ];

    protected $fillable = [
        'srismt',
        'name',
        'name_mal',
        'pen',
        'designation_id',
        'category_id',
        'aadhaarid',
        'has_punching',
        'status',
        'ot_data_entry_by_admin',
        'desig_display',
        'pan',
        'employee_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function category()
    {
        return $this->belongsTo(OtCategory::class, 'category_id');
    }
}
