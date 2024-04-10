<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    public $table = 'designations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'designation',
        'designation_mal',
        'default_time_group_id',
        'sort_index',
        'has_punching',
        'designation_without_grade',
        'designation_without_grade_mal',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function default_time_group()
    {
        return $this->belongsTo(OfficeTime::class, 'default_time_group_id');
    }
}
