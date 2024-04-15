<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAttendanceRoutingRequest;
use App\Http\Requests\StoreAttendanceRoutingRequest;
use App\Http\Requests\UpdateAttendanceRoutingRequest;
use App\Models\AttendanceRouting;
use App\Models\Employee;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceRoutingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_routing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceRoutings = AttendanceRouting::with(['viewer_js_as_ss_employee', 'viewer_seat', 'viewable_seats', 'viewable_js_as_ss_employees'])->get();

        return view('admin.attendanceRoutings.index', compact('attendanceRoutings'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendance_routing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $viewer_js_as_ss_employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $viewer_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $viewable_seats = Seat::pluck('title', 'id');

        $viewable_js_as_ss_employees = Employee::pluck('name', 'id');

        return view('admin.attendanceRoutings.create', compact('viewable_js_as_ss_employees', 'viewable_seats', 'viewer_js_as_ss_employees', 'viewer_seats'));
    }

    public function store(StoreAttendanceRoutingRequest $request)
    {
        $attendanceRouting = AttendanceRouting::create($request->all());
        $attendanceRouting->viewable_seats()->sync($request->input('viewable_seats', []));
        $attendanceRouting->viewable_js_as_ss_employees()->sync($request->input('viewable_js_as_ss_employees', []));

        return redirect()->route('admin.attendance-routings.index');
    }

    public function edit(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $viewer_js_as_ss_employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $viewer_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $viewable_seats = Seat::pluck('title', 'id');

        $viewable_js_as_ss_employees = Employee::pluck('name', 'id');

        $attendanceRouting->load('viewer_js_as_ss_employee', 'viewer_seat', 'viewable_seats', 'viewable_js_as_ss_employees');

        return view('admin.attendanceRoutings.edit', compact('attendanceRouting', 'viewable_js_as_ss_employees', 'viewable_seats', 'viewer_js_as_ss_employees', 'viewer_seats'));
    }

    public function update(UpdateAttendanceRoutingRequest $request, AttendanceRouting $attendanceRouting)
    {
        $attendanceRouting->update($request->all());
        $attendanceRouting->viewable_seats()->sync($request->input('viewable_seats', []));
        $attendanceRouting->viewable_js_as_ss_employees()->sync($request->input('viewable_js_as_ss_employees', []));

        return redirect()->route('admin.attendance-routings.index');
    }

    public function show(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceRouting->load('viewer_js_as_ss_employee', 'viewer_seat', 'viewable_seats', 'viewable_js_as_ss_employees');

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
