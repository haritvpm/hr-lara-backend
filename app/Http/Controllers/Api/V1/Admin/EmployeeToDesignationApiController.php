<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToDesignationRequest;
use App\Http\Requests\UpdateEmployeeToDesignationRequest;
use App\Http\Resources\Admin\EmployeeToDesignationResource;
use App\Models\EmployeeToDesignation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToDesignationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_to_designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToDesignationResource(EmployeeToDesignation::with(['employee', 'designation'])->get());
    }

    public function store(StoreEmployeeToDesignationRequest $request)
    {
        $employeeToDesignation = EmployeeToDesignation::create($request->all());

        return (new EmployeeToDesignationResource($employeeToDesignation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToDesignation $employeeToDesignation)
    {
        abort_if(Gate::denies('employee_to_designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToDesignationResource($employeeToDesignation->load(['employee', 'designation']));
    }

    public function update(UpdateEmployeeToDesignationRequest $request, EmployeeToDesignation $employeeToDesignation)
    {
        $employeeToDesignation->update($request->all());

        return (new EmployeeToDesignationResource($employeeToDesignation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToDesignation $employeeToDesignation)
    {
        abort_if(Gate::denies('employee_to_designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToDesignation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
