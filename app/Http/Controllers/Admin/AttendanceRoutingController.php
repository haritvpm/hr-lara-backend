<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAttendanceRoutingRequest;
use App\Http\Requests\StoreAttendanceRoutingRequest;
use App\Http\Requests\UpdateAttendanceRoutingRequest;
use App\Models\AttendanceRouting;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceRoutingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_routing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceRoutings = AttendanceRouting::with(['seats'])->get();

        return view('admin.attendanceRoutings.index', compact('attendanceRoutings'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendance_routing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::pluck('name', 'id');

        return view('admin.attendanceRoutings.create', compact('seats'));
    }

    public function store(StoreAttendanceRoutingRequest $request)
    {
        $attendanceRouting = AttendanceRouting::create($request->all());
        $attendanceRouting->seats()->sync($request->input('seats', []));

        return redirect()->route('admin.attendance-routings.index');
    }

    public function edit(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::pluck('name', 'id');

        $attendanceRouting->load('seats');

        return view('admin.attendanceRoutings.edit', compact('attendanceRouting', 'seats'));
    }

    public function update(UpdateAttendanceRoutingRequest $request, AttendanceRouting $attendanceRouting)
    {
        $attendanceRouting->update($request->all());
        $attendanceRouting->seats()->sync($request->input('seats', []));

        return redirect()->route('admin.attendance-routings.index');
    }

    public function show(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceRouting->load('seats');

        return view('admin.attendanceRoutings.show', compact('attendanceRouting'));
    }

    public function destroy(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceRouting->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttendanceRoutingRequest $request)
    {
        $attendanceRoutings = AttendanceRouting::find(request('ids'));

        foreach ($attendanceRoutings as $attendanceRouting) {
            $attendanceRouting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
