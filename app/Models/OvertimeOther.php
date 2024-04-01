<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeOther extends Model
{
    use HasFactory;

    public $table = 'overtime_others';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'designation',
        'from',
        'to',
        'count',
        'form_id',
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
        return $this->belongsTo(DeptEmployee::class, 'employee_id');
    }

    public function form()
    {
        return $this->belongsTo(OtFormOther::class, 'form_id');
    }
}
