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
        'administrative_office_id',
        'seat_of_controling_officer_id',
        'seat_of_reporting_officer_id',
        'type',
        'office_location_id',
        'works_nights_during_session',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'NORMAL'                  => 'NORMAL',
        'FAIRCOPY'                => 'FAIRCOPY',
        'OFFICE_SECTION_INWARD'   => 'OFFICE_SECTION_INWARD',
        'OFFICE_SECTION_DESPATCH' => 'OFFICE_SECTION_DESPATCH',
        'OFFICE_OF_DS'            => 'OFFICE_OF_DS',
        'OFFICE_OF_JS_AS_SS'      => 'OFFICE_OF_JS_AS_SS',
        'OFFICE_OF_SECRETARY'     => 'OFFICE_OF_SECRETARY',
        'OFFICE_OF_SPEAKER'       => 'OFFICE_OF_SPEAKER',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function sectionAttendanceBooks()
    {
        return $this->hasMany(AttendanceBook::class, 'section_id', 'id');
    }

    public function administrative_office()
    {
        return $this->belongsTo(AdministrativeOffice::class, 'administrative_office_id');
    }

    public function seat_of_controling_officer()
    {
        return $this->belongsTo(Seat::class, 'seat_of_controling_officer_id');
    }

    public function seat_of_reporting_officer()
    {
        return $this->belongsTo(Seat::class, 'seat_of_reporting_officer_id');
    }

    public function office_location()
    {
        return $this->belongsTo(OfficeLocation::class, 'office_location_id');
    }
}
