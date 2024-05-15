<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompenGranted extends Model
{
    use HasFactory;

    public $table = 'compen_granteds';

    protected $dates = [
        'date_of_work',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'aadhaarid',
        'date_of_work',
        'is_for_extra_hours',
        'employee_id',
        'leave_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateOfWorkAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfWorkAttribute($value)
    {
        $this->attributes['date_of_work'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function leave()
    {
        return $this->belongsTo(Leaf::class, 'leave_id');
    }
}
