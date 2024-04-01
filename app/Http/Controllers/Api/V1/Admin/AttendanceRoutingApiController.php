<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceRoutingRequest;
use App\Http\Requests\UpdateAttendanceRoutingRequest;
use App\Http\Resources\Admin\AttendanceRoutingResource;
use App\Models\AttendanceRouting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceRoutingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_routing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendanceRoutingResource(AttendanceRouting::with(['seats'])->get());
    }

    public function store(StoreAttendanceRoutingRequest $request)
    {
        $attendanceRouting = AttendanceRouting::create($request->all());
        $attendanceRouting->seats()->sync($request->input('seats', []));

        return (new AttendanceRoutingResource($attendanceRouting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendanceRoutingResource($attendanceRouting->load(['seats']));
    }

    public function update(UpdateAttendanceRoutingRequest $request, AttendanceRouting $attendanceRouting)
    {
        $attendanceRouting->update($request->all());
        $attendanceRouting->seats()->sync($request->input('seats', []));

        return (new AttendanceRoutingResource($attendanceRouting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttendanceRouting $attendanceRouting)
    {
        abort_if(Gate::denies('attendance_routing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceRouting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
