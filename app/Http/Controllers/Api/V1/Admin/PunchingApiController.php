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

        if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser)==0) {
            return response()->json(['status' => 'No seats in charge'], 400);
        }

        //call employeeservice get loggedusersubordinate
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $date, $date, $seat_ids_of_loggedinuser, $me);
        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        $data_monthly = (new PunchingService())->calculate($date, $aadhaarids )->mapwithKeys(function ($item) {
            return [$item['aadhaarid'] => $item];
        });

        $data2 = Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave'])
        ->wherein('aadhaarid', $aadhaarids)
        ->where('date', $date)
        ->get();
        //for each employee get
        $data2->transform(function($item, $key) use ($data_monthly){
            $aadharid = $item['aadhaarid'];
            $item['total_grace_sec'] = $data_monthly[ $aadharid ][ 'total_grace_sec' ];
            $item['total_extra_sec'] = $data_monthly[ $aadharid ][ 'total_extra_sec' ];
            $item['cl_taken'] = $data_monthly[ $aadharid ][ 'cl_taken' ];
         
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

        if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser)==0) {
            return response()->json(['status' => 'No seats in charge'], 400);
        }

        //todo. make this a period
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees(
            $start_date, $end_date, $seat_ids_of_loggedinuser, $me);
        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

      //  $data_monthly = (new PunchingService())->calculateMonthlyAttendance($date_str, $aadhaarids );

        $data2 = Punching::with(['employee'])
        ->wherein('aadhaarid', $aadhaarids)
        ->whereBetween('date', [$start_date, $end_date])
        ->get();

        //for each employee in punching as a row, show columns for each day of month
        //{position: 1, name: 'Hydrogen', weight: 1.0079, symbol: 'H'},
        $data3 = [];
        foreach( $data2 as $punching){
            $item = [];
            $punching->date = Carbon::parse($punching->date)->format('d');

            $data3[] = $item;
        }
    


        return response()->json([
         //   'monthly' => $data_monthly->groupBy('aadhaarid'),
        //  'sections_under_charge' => $data->pluck('section_name')->unique(),
            'monthlypunchings' => $data3,
           // 'employees_in_view' =>  $employees_in_view->groupBy('aadhaarid'),
        ], 200);

    }
    
}
