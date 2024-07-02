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
    public static function recurseGetSuperiorOfficers( $baseSeatIds, &$seats)
    {
        //$seatIdOfController is superior officer. no doubt about it.
        //so find parent attendance routing if any.
        $seniorOfficerseats = AttendanceRouting::with('viewable_seats')
        ->whereHas('viewable_seats', function($q) use ($baseSeatIds){
            $q->wherein('id', $baseSeatIds);
        })->get();
        $seniorOfficerseats = $seniorOfficerseats->pluck('viewer_seat_id')->flatten()->toArray();
//\Log::info("seniorOfficerseats");
//\Log::info($seniorOfficerseats);
        if(count($seniorOfficerseats))
        {
           // $seniorOfficerseats = $seats->pluck('viewer_seats')->flatten()->pluck('id');
            array_push($seats,...$seniorOfficerseats);
            return AttendanceRouting::recurseGetSuperiorOfficers($seniorOfficerseats, $seats);
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
       // \Log::info('seats');
        //\Log::info($seats);
        $seats = $seats->pluck('viewable_seats')->flatten()->pluck('id');
        //\Log::info($seats);

        return $seats;

    }
    public static function getForwardableSeats( $seatIdOfEmployeeController, $seatIdOfSO, $seat_ids_of_loggedinuser, $minLevel = -1)
    {
        //also get reporting officer seat, controller, and all seat above this user in routing
        $forwardable_seats = [];
        $baseSeatIds = [];

        if($seatIdOfEmployeeController){
            $baseSeatIds[] = $seatIdOfEmployeeController;
            $forwardable_seats[] = $seatIdOfEmployeeController;
        }
        else
        if(!$seatIdOfEmployeeController && $seat_ids_of_loggedinuser)
            $baseSeatIds = $seat_ids_of_loggedinuser;



        if($seatIdOfSO)
        {
            $forwardable_seats[] = $seatIdOfSO;
        }
        \Log::info('$baseSeatIds' );
        \Log::info($baseSeatIds );

        //now find officer just above controller.
        $routing = AttendanceRouting::recurseGetSuperiorOfficers($baseSeatIds, $forwardable_seats);
        \Log::info('routes');
        $forwardable_seats = array_unique($forwardable_seats, SORT_REGULAR);
        $forwardable_seats = array_values($forwardable_seats);
       // \Log::info($forwardable_seats );

        if(count($forwardable_seats) ==0){
            //suppose I am SO. I am not in routing.
            //So find my section's controller
            $controllers = Section::
                wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)
                ->where('seat_of_controlling_officer_id', '<>', 'seat_of_reporting_officer_id'  )
                ->pluck('seat_of_controlling_officer_id');


            $forwardable_seats = array_merge($forwardable_seats, $controllers->toArray());

        }
       // \Log::info('forwardable_seats');
        //\Log::info($forwardable_seats );

        $forwardable_seats_backup = $forwardable_seats;
        \Log::info('minLevel');
        \Log::info($minLevel);
        if($minLevel > 0)
        {
            $forwardable_seats = Seat::whereIn('id', $forwardable_seats)
                                    ->where('level', '>=', $minLevel)
                                    ->pluck('id');

            //\Log::info('forwardable_seats');
            //\Log::info($forwardable_seats );
            //if no seat found at this level, then find all seats above this level
            if(count($forwardable_seats) == 0)
            {

                $forwardable_seats = Seat::where('level', '>=', $minLevel)->pluck('id');
            }

        }


        $seats = EmployeeToSeat::with(['seat', 'employee'])
                    ->wherenotnull('employee_id')
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

    public static function getLeaveForwardableSeat( $employee_id, $seat_ids_of_loggedinuser )
    {
         //find the owner seat which is the reporting officer of this employee's section
        $sectionOfficerSeat = $controllerSeat = null;

        $sectionMapping = EmployeeToSection::with('section')->OnDate(now()->format('Y-m-d'))->where('employee_id', $employee_id)->first();
        if ($sectionMapping) {
            //\Log::info('sectionMapping');
            $sectionOfficerSeat = $sectionMapping->section->seat_of_reporting_officer_id;
            $controllerSeat = $sectionMapping->section->seat_of_controlling_officer_id;
            return [
                $sectionOfficerSeat,$controllerSeat
            ];

        }
        //employee might be like section officer who has no routing but is in section

        $section = Section::where('type', 'NORMAL')
        ->wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)->first();
        if($section)
        {
            //\Log::info('section');

            $sectionOfficerSeat = $section->seat_of_reporting_officer_id;
            $controllerSeat = $section->seat_of_controlling_officer_id;
            return [
                $sectionOfficerSeat,$controllerSeat
            ];
        }

        //employee might be like undersec who is not in any section. So find his seat.

        //sorting by level will give the lowestr most officer
        //example JS has SS and secretary in routing (secretary to see JS's attendance)
        //so return SS's seat
        $seniorOfficer = AttendanceRouting::with(['viewable_seats','viewer_seat'])
        ->whereHas('viewable_seats', function($q) use ($seat_ids_of_loggedinuser){
            $q->wherein('id', $seat_ids_of_loggedinuser);
        })
        ->get()
        ->sortBy(function($route, $key) {
            return $route->viewer_seat->level;
          })
        ->first();

        \Log::info('seniorOfficer');
        \Log::info($seniorOfficer);
       // $seniorOfficerseat = $seniorOfficer?->pluck('viewer_seat_id')->first();
        $seniorOfficerseat = $seniorOfficer?->viewer_seat_id;

        if($seniorOfficerseat)
        {
            $sectionOfficerSeat =  $controllerSeat = $seniorOfficerseat;
        }

        return [
            $sectionOfficerSeat,$controllerSeat
        ];
    }
}
