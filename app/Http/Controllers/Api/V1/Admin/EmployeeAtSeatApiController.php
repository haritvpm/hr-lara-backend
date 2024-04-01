<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeAtSeatRequest;
use App\Http\Requests\UpdateEmployeeAtSeatRequest;
use App\Http\Resources\Admin\EmployeeAtSeatResource;
use App\Models\EmployeeAtSeat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAtSeatApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_at_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeAtSeatResource(EmployeeAtSeat::with(['employee', 'seat'])->get());
    }

    public function store(StoreEmployeeAtSeatRequest $request)
    {
        $employeeAtSeat = EmployeeAtSeat::create($request->all());

        return (new EmployeeAtSeatResource($employeeAtSeat))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeAtSeat $employeeAtSeat)
    {
        abort_if(Gate::denies('employee_at_seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeAtSeatResource($employeeAtSeat->load(['employee', 'seat']));
    }

    public function update(UpdateEmployeeAtSeatRequest $request, EmployeeAtSeat $employeeAtSeat)
    {
        $employeeAtSeat->update($request->all());

        return (new EmployeeAtSeatResource($employeeAtSeat))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeAtSeat $employeeAtSeat)
    {
        abort_if(Gate::denies('employee_at_seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAtSeat->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
