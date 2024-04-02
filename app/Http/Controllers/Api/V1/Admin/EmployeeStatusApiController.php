<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeStatusRequest;
use App\Http\Requests\UpdateEmployeeStatusRequest;
use App\Http\Resources\Admin\EmployeeStatusResource;
use App\Models\EmployeeStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeStatusResource(EmployeeStatus::all());
    }

    public function store(StoreEmployeeStatusRequest $request)
    {
        $employeeStatus = EmployeeStatus::create($request->all());

        return (new EmployeeStatusResource($employeeStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeStatusResource($employeeStatus);
    }

    public function update(UpdateEmployeeStatusRequest $request, EmployeeStatus $employeeStatus)
    {
        $employeeStatus->update($request->all());

        return (new EmployeeStatusResource($employeeStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
