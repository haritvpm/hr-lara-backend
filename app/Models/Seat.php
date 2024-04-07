<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    public $table = 'seats';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'slug',
        'title',
        'has_files',
        'has_office_with_employees',
        'is_js_as_ss',
        'is_controlling_officer',
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function createdByTaxEntries()
    {
        return $this->hasMany(TaxEntry::class, 'created_by_id', 'id');
    }

    public function seatsAttendanceRoutings()
    {
        return $this->belongsToMany(AttendanceRouting::class);
    }

    public function toSeatsOtRoutings()
    {
        return $this->belongsToMany(OtRouting::class);
    }
}
