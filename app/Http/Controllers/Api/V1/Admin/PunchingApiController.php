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

        //need to move things to services later

        //get current logged in user's charges
        $me = User::with('employee')->find(auth()->id());

        if ($me->employee_id == null) {
            return response()->json(['status' => 'No linked employee'], 400);
        }

        //find my seat if I am JS
        $seat_ids = EmployeeToSeat::with('seat')->where('employee_id', $me->employee_id)->get()->pluck('seat.id');

        $sections_with_charge = Section::wherein('seat_of_controlling_officer_id', $seat_ids)
            ->orwherein('seat_of_reporting_officer_id', $seat_ids)
            ->orwhere('js_as_ss_employee_id', $me->employee_id)->get();

        if ($sections_with_charge == null) {
            return response()->json(['status' => 'No sections in charge'], 400);
        }
        //this has to be rewritten. we need to give emp data from Punchings which has to calculated after
        //we call our api refresh.
        $employee_section_maps = EmployeeToSection::during($date)->with(['employee', 'attendance_book'])
            ->wherein('section_seat_id', $sections_with_charge->pluck('id'))
             ->get();

        //   $data = (new PunchingService())->calculate($date);
        return response()->json([
            'status' => 'success',
            'seats' => $seat_ids,
            'sections_with_charge' => $sections_with_charge,
            'employee_section_maps' => $employee_section_maps,
            //  'punchings' => $data
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
