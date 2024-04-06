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
        'office_times_id',
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

    public function office_times()
    {
        return $this->belongsTo(OfficeTime::class, 'office_times_id');
    }
}
