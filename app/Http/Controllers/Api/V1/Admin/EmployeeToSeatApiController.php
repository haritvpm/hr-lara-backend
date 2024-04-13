<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToSeatRequest;
use App\Http\Requests\UpdateEmployeeToSeatRequest;
use App\Http\Resources\Admin\EmployeeToSeatResource;
use App\Models\EmployeeToSeat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToSeatApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_to_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToSeatResource(EmployeeToSeat::with(['seat', 'employee'])->get());
    }

    public function store(StoreEmployeeToSeatRequest $request)
    {
        $employeeToSeat = EmployeeToSeat::create($request->all());

        return (new EmployeeToSeatResource($employeeToSeat))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToSeat $employeeToSeat)
    {
        abort_if(Gate::denies('employee_to_seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToSeatResource($employeeToSeat->load(['seat', 'employee']));
    }

    public function update(UpdateEmployeeToSeatRequest $request, EmployeeToSeat $employeeToSeat)
    {
        $employeeToSeat->update($request->all());

        return (new EmployeeToSeatResource($employeeToSeat))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToSeat $employeeToSeat)
    {
        abort_if(Gate::denies('employee_to_seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSeat->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
