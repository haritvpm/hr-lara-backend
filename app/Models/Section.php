<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public $table = 'sections';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'short_code',
        'seat_of_controlling_officer_id',
        'office_location_id',
        'seat_of_reporting_officer_id',
        'js_as_ss_employee_id',
        'type',
        'works_nights_during_session',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'NORMAL'              => 'NORMAL',
        'FAIRCOPY'            => 'FAIRCOPY',
        'OFFICE_SECTION'      => 'OFFICE_SECTION',
        'OFFICE_OF_DS'        => 'OFFICE_OF_DS',
        'OFFICE_OF_JS_AS_SS'  => 'OFFICE_OF_JS_AS_SS',
        'OFFICE_OF_SECRETARY' => 'OFFICE_OF_SECRETARY',
        'OFFICE_OF_SPEAKER'   => 'OFFICE_OF_SPEAKER',
        'OTHER'               => 'OTHER',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sectionAttendanceBooks()
    {
        return $this->hasMany(AttendanceBook::class, 'section_id', 'id');
    }

    public function seat_of_controlling_officer()
    {
        return $this->belongsTo(Seat::class, 'seat_of_controlling_officer_id');
    }

    public function office_location()
    {
        return $this->belongsTo(OfficeLocation::class, 'office_location_id');
    }

    public function seat_of_reporting_officer()
    {
        return $this->belongsTo(Seat::class, 'seat_of_reporting_officer_id');
    }

    public function js_as_ss_employee()
    {
        return $this->belongsTo(Employee::class, 'js_as_ss_employee_id');
    }
}
