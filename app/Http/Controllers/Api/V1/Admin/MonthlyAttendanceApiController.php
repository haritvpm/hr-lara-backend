<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyAttendanceRequest;
use App\Http\Requests\UpdateMonthlyAttendanceRequest;
use App\Http\Resources\Admin\MonthlyAttendanceResource;
use App\Models\MonthlyAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyAttendanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MonthlyAttendanceResource(MonthlyAttendance::with(['employee'])->get());
    }

    public function store(StoreMonthlyAttendanceRequest $request)
    {
        $monthlyAttendance = MonthlyAttendance::create($request->all());

        return (new MonthlyAttendanceResource($monthlyAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MonthlyAttendanceResource($monthlyAttendance->load(['employee']));
    }

    public function update(UpdateMonthlyAttendanceRequest $request, MonthlyAttendance $monthlyAttendance)
    {
        $monthlyAttendance->update($request->all());

        return (new MonthlyAttendanceResource($monthlyAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
