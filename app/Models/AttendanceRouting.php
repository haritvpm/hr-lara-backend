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
    public static function recurseGetSuperiorOfficers( $seatIdOfEmployeeController, &$seats)
    {
        //$seatIdOfController is superior officer. no doubt about it.
        //so find parent attendance routing if any.
        $seniorOfficer = AttendanceRouting::with('viewable_seats')
        ->whereHas('viewable_seats', function($q) use ($seatIdOfEmployeeController){
            $q->where('id', $seatIdOfEmployeeController);
        })->first();


        if($seniorOfficer)
        {
            array_push($seats, $seniorOfficer->viewer_seat_id);
            return AttendanceRouting::recurseGetSuperiorOfficers($seniorOfficer->viewer_seat_id, $seats);
        }
        else
        {
            return $seats;
        }
    }
    public static function getSeatsUnderMyDirectControl( $seat_ids_of_loggedinuser)
    {

        $seats = AttendanceRouting::with(['viewable_seats', 'viewer_seat'])
        ->whereHas('viewer_seat', function($q) use ($seat_ids_of_loggedinuser){
            $q->wherein('id', $seat_ids_of_loggedinuser);
        })->get();
        \Log::info('seats');
        \Log::info($seats);
        $seats = $seats->pluck('viewable_seats')->flatten()->pluck('id');
        \Log::info($seats);

        return $seats;

    }
    public static function getForwardableSeats( $seatIdOfEmployeeController, $seatIdOfSO, $seat_ids_of_loggedinuser)
    {
        //also get reporting officer seat, controller, and all seat above this user in routing
        $forwardable_seats = [];
        $baseSeatId = $seatIdOfEmployeeController;
        if(!$seatIdOfEmployeeController && $seat_ids_of_loggedinuser)
            $baseSeatId = $seat_ids_of_loggedinuser;
        else if($seatIdOfEmployeeController)
            $forwardable_seats[] = $seatIdOfEmployeeController;

        if($seatIdOfSO)
        {
            $forwardable_seats[] = $seatIdOfSO;
        }

        //now find officer just above controller.
        $routing = AttendanceRouting::recurseGetSuperiorOfficers($baseSeatId, $forwardable_seats);
        \Log::info('routes');
        $forwardable_seats = array_unique($forwardable_seats);
        $forwardable_seats = array_values($forwardable_seats);
        \Log::info($forwardable_seats );

        if(count($forwardable_seats) ==0){
            //suppose I am SO. I am not in routing.
            //So find my section's controller
            $controllers = Section::
                wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)
                ->where('seat_of_controlling_officer_id', '<>', 'seat_of_reporting_officer_id'  )
                ->pluck('seat_of_controlling_officer_id');
               // \Log::info('$seat_ids_of_loggedinuser' );
               // \Log::info($seat_ids_of_loggedinuser );
               // \Log::info($controllers );

           // $forwardable_seats = array_merge($forwardable_seats, $controllers->toArray());

        }
        \Log::info('forwardable_seats');
        \Log::info($forwardable_seats );

        $seats = EmployeeToSeat::with(['seat', 'employee'])
        ->wherein('seat_id', $forwardable_seats)
        ->get()->transform( function($seat) {
            return [
                'seat_id' => $seat->seat->id,
                'seat_name' => $seat->seat->title,
                'employee_name' => $seat->employee->name,
                'employee_id' => $seat->employee->id,
                'level' => $seat->seat->level,
            ];
        })->sortBy('level')->values();

        return $seats;


    }
}
