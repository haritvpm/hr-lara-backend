<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    public $table = 'overtimes';

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
        'punchin_id',
        'punchout_id',
        'slots',
        'has_punching',
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

    public function form()
    {
        return $this->belongsTo(OtForm::class, 'form_id');
    }

    public function punchin()
    {
        return $this->belongsTo(PunchingTrace::class, 'punchin_id');
    }

    public function punchout()
    {
        return $this->belongsTo(PunchingTrace::class, 'punchout_id');
    }
}
