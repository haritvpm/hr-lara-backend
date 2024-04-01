<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeptEmployeeRequest;
use App\Http\Requests\UpdateDeptEmployeeRequest;
use App\Http\Resources\Admin\DeptEmployeeResource;
use App\Models\DeptEmployee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeptEmployeesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dept_employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeptEmployeeResource(DeptEmployee::with(['designation'])->get());
    }

    public function store(StoreDeptEmployeeRequest $request)
    {
        $deptEmployee = DeptEmployee::create($request->all());

        return (new DeptEmployeeResource($deptEmployee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DeptEmployee $deptEmployee)
    {
        abort_if(Gate::denies('dept_employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeptEmployeeResource($deptEmployee->load(['designation']));
    }

    public function update(UpdateDeptEmployeeRequest $request, DeptEmployee $deptEmployee)
    {
        $deptEmployee->update($request->all());

        return (new DeptEmployeeResource($deptEmployee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeptEmployee $deptEmployee)
    {
        abort_if(Gate::denies('dept_employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptEmployee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
