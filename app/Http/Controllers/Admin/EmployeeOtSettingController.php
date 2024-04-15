<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeOtSettingRequest;
use App\Http\Requests\StoreEmployeeOtSettingRequest;
use App\Http\Requests\UpdateEmployeeOtSettingRequest;
use App\Models\Employee;
use App\Models\EmployeeOtSetting;
use App\Models\OtCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeOtSettingController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_ot_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtSettings = EmployeeOtSetting::with(['employee', 'ot_excel_category'])->get();

        return view('admin.employeeOtSettings.index', compact('employeeOtSettings'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_ot_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ot_excel_categories = OtCategory::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeOtSettings.create', compact('employees', 'ot_excel_categories'));
    }

    public function store(StoreEmployeeOtSettingRequest $request)
    {
        $employeeOtSetting = EmployeeOtSetting::create($request->all());

        return redirect()->route('admin.employee-ot-settings.index');
    }

    public function edit(EmployeeOtSetting $employeeOtSetting)
    {
        abort_if(Gate::denies('employee_ot_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ot_excel_categories = OtCategory::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeOtSetting->load('employee', 'ot_excel_category');

        return view('admin.employeeOtSettings.edit', compact('employeeOtSetting', 'employees', 'ot_excel_categories'));
    }

    public function update(UpdateEmployeeOtSettingRequest $request, EmployeeOtSetting $employeeOtSetting)
    {
        $employeeOtSetting->update($request->all());

        return redirect()->route('admin.employee-ot-settings.index');
    }

    public function show(EmployeeOtSetting $employeeOtSetting)
    {
        abort_if(Gate::denies('employee_ot_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtSetting->load('employee', 'ot_excel_category');

        return view('admin.employeeOtSettings.show', compact('employeeOtSetting'));
    }

    public function destroy(EmployeeOtSetting $employeeOtSetting)
    {
        abort_if(Gate::denies('employee_ot_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeOtSettingRequest $request)
    {
        $employeeOtSettings = EmployeeOtSetting::find(request('ids'));

        foreach ($employeeOtSettings as $employeeOtSetting) {
            $employeeOtSetting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
