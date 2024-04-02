<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToShiftRequest;
use App\Http\Requests\UpdateEmployeeToShiftRequest;
use App\Http\Resources\Admin\EmployeeToShiftResource;
use App\Models\EmployeeToShift;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToShiftApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_to_shift_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToShiftResource(EmployeeToShift::with(['employee', 'shift'])->get());
    }

    public function store(StoreEmployeeToShiftRequest $request)
    {
        $employeeToShift = EmployeeToShift::create($request->all());

        return (new EmployeeToShiftResource($employeeToShift))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToShift $employeeToShift)
    {
        abort_if(Gate::denies('employee_to_shift_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToShiftResource($employeeToShift->load(['employee', 'shift']));
    }

    public function update(UpdateEmployeeToShiftRequest $request, EmployeeToShift $employeeToShift)
    {
        $employeeToShift->update($request->all());

        return (new EmployeeToShiftResource($employeeToShift))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToShift $employeeToShift)
    {
        abort_if(Gate::denies('employee_to_shift_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToShift->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
