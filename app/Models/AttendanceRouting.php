<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRouting extends Model
{
    use HasFactory;

    public $table = 'attendance_routings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'js_id',
        'as_id',
        'ss_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class);
    }

    public function js()
    {
        return $this->belongsTo(User::class, 'js_id');
    }

    public function as()
    {
        return $this->belongsTo(User::class, 'as_id');
    }

    public function ss()
    {
        return $this->belongsTo(User::class, 'ss_id');
    }
}
