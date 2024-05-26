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
        'viewer_seat_id',
        'viewer_js_as_ss_employee_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function viewer_js_as_ss_employee()
    {
        return $this->belongsTo(Employee::class, 'viewer_js_as_ss_employee_id');
    }

    public function viewer_seat()
    {
        return $this->belongsTo(Seat::class, 'viewer_seat_id');
    }

    public function viewable_seats()
    {
        return $this->belongsToMany(Seat::class);
    }

    public function viewable_js_as_ss_employees()
    {
        return $this->belongsToMany(Employee::class);
    }
    public static function recurseFindIfSuperiorOfficer( $seat_ids_of_loggedinuser, $seatIdOfEmployeeController)
    {
        //$seatIdOfController is superior officer. no doubt about it.
        //so find parent attendance routing if any.
        $seniorOfficer = AttendanceRouting::with('viewable_seats')->whereHas('viewable_seats', function($q) use ($seatIdOfEmployeeController){
            $q->where('id', $seatIdOfEmployeeController);
        })->first();

        if( $seniorOfficer && $seat_ids_of_loggedinuser->contains($seniorOfficer->viewer_seat_id) )
        {
            return true;
        }
        else if($seniorOfficer)
        {
            return AttendanceRouting::recurseFindIfSuperiorOfficer($seat_ids_of_loggedinuser, $seniorOfficer->viewer_seat_id);
        }
        else
        {
            return false;
        }

    }
}
