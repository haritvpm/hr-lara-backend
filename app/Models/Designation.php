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
        'sort_index',
        'has_punching',
        'desig_line_id',
        'designation_wo_grade_id',
        'time_group_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function desig_line()
    {
        return $this->belongsTo(DesignationLine::class, 'desig_line_id');
    }

    public function designation_wo_grade()
    {
        return $this->belongsTo(DesignationWithoutGrade::class, 'designation_wo_grade_id');
    }

    public function time_group()
    {
        return $this->belongsTo(OfficeTimeGroup::class, 'time_group_id');
    }
}
