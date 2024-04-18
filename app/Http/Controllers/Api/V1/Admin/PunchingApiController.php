<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRequest;
use App\Http\Requests\UpdatePunchingRequest;
use App\Http\Resources\Admin\PunchingResource;
use App\Models\User;
use App\Models\PunchingTrace;
use App\Models\EmployeeToSeat;
use App\Models\Punching;
use App\Models\Section;
use App\Models\EmployeeToSection;
use App\Models\GovtCalendar;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Services\PunchingService;
use App\Services\EmployeeService;


class PunchingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('punching_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingResource(Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section'])->get());
    }

    public function store(StorePunchingRequest $request)
    {
        $punching = Punching::create($request->all());

        return (new PunchingResource($punching))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Punching $punching)
    {
        abort_if(Gate::denies('punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingResource($punching->load(['employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section']));
    }

    public function update(UpdatePunchingRequest $request, Punching $punching)
    {
        $punching->update($request->all());

        return (new PunchingResource($punching))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }


    public function getpunchings(Request $request)
    {

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now(); //today
        $date =  $date->format('Y-m-d');
        //get current logged in user's charges
        $me = User::with('employee')->find(auth()->id());

        if ($me->employee_id == null) {
            return response()->json(['status' => 'No linked employee'], 400);
        }
        $seat_ids_of_loggedinuser = EmployeeToSeat::where('employee_id', $me->employee_id)->get()->pluck('seat_id');

        if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser) == 0) {
            return response()->json(['status' => 'No seats in charge'], 400);
        }

        //call employeeservice get loggedusersubordinate
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $date,
            $date,
            $seat_ids_of_loggedinuser,
            $me
        );
        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        //this should be done when we finish aebas fetch
        $data_monthly = (new PunchingService())->calculate($date, $aadhaarids)->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

        $data2 = Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave'])
            ->wherein('aadhaarid', $aadhaarids)
            ->where('date', $date)
            ->get();
        //for each employee get
        $data2->transform(function ($item, $key) use ($data_monthly) {
            $aadharid = $item['aadhaarid'];
            $item['total_grace_sec'] = $data_monthly[$aadharid]['total_grace_sec'];
            $item['total_extra_sec'] = $data_monthly[$aadharid]['total_extra_sec'];
            $item['cl_taken'] = $data_monthly[$aadharid]['cl_taken'];

            return $item;
        });

        return response()->json([
            //            'data_monthly' => $data_monthly,
            'punchings' => $data2,
            //   'employees_in_view' =>  $employees_in_view->groupBy('aadhaarid'),
        ], 200);
    }
    public function getmonthlypunchings(Request $request)
    {

        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now(); //today
        $start_date = $date->startOfMonth()->format('Y-m-d');
        $end_date = $date->endOfMonth()->format('Y-m-d');
        $date_str = $date->format('Y-m-d');

        //get current logged in user's charges
        $me = User::with('employee')->find(auth()->id());

        if ($me->employee_id == null) {
            return response()->json(['status' => 'No linked employee'], 400);
        }
        $seat_ids_of_loggedinuser = EmployeeToSeat::where('employee_id', $me->employee_id)->get()->pluck('seat_id');

        if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser) == 0) {
            return response()->json(['status' => 'No seats in charge'], 400);
        }

        //todo. make this a period
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $start_date,
            $end_date,
            $seat_ids_of_loggedinuser,
            $me
        );
     //   $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        //get all govtcalender between start data and enddate
        $calender = GovtCalendar::whereBetween('date', [$start_date, $end_date])->get()->mapwithKeys(function ($item) {
            return [$item['date'] => $item];
        });
        $calender_info = [];
        for ($i = 1; $i <= $date->daysInMonth; $i++) {

            $d = $date->day($i);
            $d_str = $d->format('Y-m-d');
            $calender_info['day' . $i]['holiday'] = $calender[$d_str]->govtholidaystatus ?? false;
            $calender_info['day' . $i]['rh'] = $calender[$d_str]->restrictedholidaystatus ?? false;
            $calender_info['day' . $i]['office_ends_at'] = $calender[$d_str]->office_ends_at ?? '';
            $calender_info['day' . $i]['future_date'] = $d->gt(Carbon::now());
            $calender_info['day' . $i]['is_today'] = $d->isToday();
        }

        //  $data_monthly = (new PunchingService())->calculateMonthlyAttendance($date_str, $aadhaarids );
        $data3 = [];
        foreach ($employees_in_view as $employee) {

            $item =  $employee;
            $aadhaarid = $employee['aadhaarid'];
            //for each employee in punching as a row, show columns for each day of month
            //{position: 1, name: 'Hydrogen', weight: 1.0079, symbol: 'H'},
            for ($i = 1; $i <= $date->daysInMonth; $i++) {

                $d = $date->day($i);
                $d_str = $d->format('Y-m-d');
                $emp_start_date = Carbon::parse($employee['start_date']);
                $emp_end_date = Carbon::parse($employee['end_date']);

                $dayinfo = [];
                // $dayinfo['holiday'] = $calender[$d_str]->govtholidaystatus ?? false;
                // $dayinfo['rh'] = $calender[$d_str]->restrictedholidaystatus ?? false;
                // $dayinfo['office_ends_at'] = $calender[$d_str]->office_ends_at ?? '';
                // $dayinfo['future_date'] = $d->gt(Carbon::now());
                // $dayinfo['is_today'] = $d->isToday();
                //for each date, get employee's punching data
                //is this holiday ?
//                \Log::info( $d);

                if ($emp_start_date <= $d && $emp_end_date >= $d) {

                    $dayinfo['in_section'] = true;
                    $dayinfo['punching_count'] = 0; //this will be overwritten when punching is got below
                    $punching = Punching::where('aadhaarid', $aadhaarid)->where('date', $d_str)->first();
                    if ($punching) {
                       //copy all properties of $punching to $dayinfo
                        $dayinfo = [...$dayinfo, ...$punching->toArray()];
                    } else {
                        //no punching found
                    }

                } else {
                    $dayinfo = [...$dayinfo, ...['in_section' => false ]];
                }

                $item['day' . $i] = [...$dayinfo];
            }

            $data3[] = $item;
        }

         return response()->json([
            'calender_info' => $calender_info,
            //  'sections_under_charge' => $data->pluck('section_name')->unique(),
            'monthlypunchings' => $data3,
            // 'employees_in_view' =>  $employees_in_view->groupBy('aadhaarid'),
        ], 200);
    }
}
