<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeToSection extends Model
{
    use HasFactory;

    public $table = 'employee_to_sections';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'section_seat_id',
        'attendance_book_id',
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

    public function section_seat()
    {
        return $this->belongsTo(Seat::class, 'section_seat_id');
    }

    public function attendance_book()
    {
        return $this->belongsTo(AttendanceBook::class, 'attendance_book_id');
    }
}
