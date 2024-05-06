<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYearlyAttendanceRequest;
use App\Http\Requests\UpdateYearlyAttendanceRequest;
use App\Http\Resources\Admin\YearlyAttendanceResource;
use App\Models\YearlyAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class YearlyAttendanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearlyAttendanceResource(YearlyAttendance::with(['employee'])->get());
    }

    public function store(StoreYearlyAttendanceRequest $request)
    {
        $yearlyAttendance = YearlyAttendance::create($request->all());

        return (new YearlyAttendanceResource($yearlyAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(YearlyAttendance $yearlyAttendance)
    {
        abort_if(Gate::denies('yearly_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearlyAttendanceResource($yearlyAttendance->load(['employee']));
    }

    public function update(UpdateYearlyAttendanceRequest $request, YearlyAttendance $yearlyAttendance)
    {
        $yearlyAttendance->update($request->all());

        return (new YearlyAttendanceResource($yearlyAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(YearlyAttendance $yearlyAttendance)
    {
        abort_if(Gate::denies('yearly_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearlyAttendance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
