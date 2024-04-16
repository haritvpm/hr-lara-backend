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
        $employees_in_view = (new EmployeeService())->getLoggedUserSubordinateEmployees($date, $seat_ids_of_loggedinuser, $me);
        $aadhaarids = $employees_in_view->pluck('aadhaarid')->unique();

        $data = (new PunchingService())->calculate($date, $aadhaarids );

        //for each employee get 

        return response()->json([
            //    'seats' => $seat_ids,
          //  'sections_under_charge' => $data->pluck('section_name')->unique(),
            'punchings' => $data,
        ], 200);

        //  \Log::info("got" . $request->date);
        /*
      $punchingstest = Punching::where('date', $date->format('Y-m-d'))->get();
      return response()->json([
        'status' => 'success',
        'punchings' => $punchingstest
        ]);

        */
    }
}
