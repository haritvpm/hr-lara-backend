<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeOtDataRequest;
use App\Http\Requests\UpdateEmployeeOtDataRequest;
use App\Http\Resources\Admin\EmployeeOtDataResource;
use App\Models\EmployeeOtData;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeOtDataApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_ot_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeOtDataResource(EmployeeOtData::with(['employee', 'ot_excel_category'])->get());
    }

    public function store(StoreEmployeeOtDataRequest $request)
    {
        $employeeOtData = EmployeeOtData::create($request->all());

        return (new EmployeeOtDataResource($employeeOtData))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeOtData $employeeOtData)
    {
        abort_if(Gate::denies('employee_ot_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeOtDataResource($employeeOtData->load(['employee', 'ot_excel_category']));
    }

    public function update(UpdateEmployeeOtDataRequest $request, EmployeeOtData $employeeOtData)
    {
        $employeeOtData->update($request->all());

        return (new EmployeeOtDataResource($employeeOtData))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeOtData $employeeOtData)
    {
        abort_if(Gate::denies('employee_ot_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtData->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
