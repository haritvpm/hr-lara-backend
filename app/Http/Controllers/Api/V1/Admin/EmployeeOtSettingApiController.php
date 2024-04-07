<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeOtSettingRequest;
use App\Http\Requests\UpdateEmployeeOtSettingRequest;
use App\Http\Resources\Admin\EmployeeOtSettingResource;
use App\Models\EmployeeOtSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeOtSettingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_ot_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeOtSettingResource(EmployeeOtSetting::with(['employee', 'ot_excel_category'])->get());
    }

    public function store(StoreEmployeeOtSettingRequest $request)
    {
        $employeeOtSetting = EmployeeOtSetting::create($request->all());

        return (new EmployeeOtSettingResource($employeeOtSetting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeOtSetting $employeeOtSetting)
    {
        abort_if(Gate::denies('employee_ot_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeOtSettingResource($employeeOtSetting->load(['employee', 'ot_excel_category']));
    }

    public function update(UpdateEmployeeOtSettingRequest $request, EmployeeOtSetting $employeeOtSetting)
    {
        $employeeOtSetting->update($request->all());

        return (new EmployeeOtSettingResource($employeeOtSetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeOtSetting $employeeOtSetting)
    {
        abort_if(Gate::denies('employee_ot_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtSetting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
