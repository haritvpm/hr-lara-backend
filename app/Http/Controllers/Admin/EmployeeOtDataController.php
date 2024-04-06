<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeOtDataRequest;
use App\Http\Requests\StoreEmployeeOtDataRequest;
use App\Http\Requests\UpdateEmployeeOtDataRequest;
use App\Models\Employee;
use App\Models\EmployeeOtData;
use App\Models\OtCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeOtDataController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_ot_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtDatas = EmployeeOtData::with(['employee', 'ot_excel_category'])->get();

        return view('admin.employeeOtDatas.index', compact('employeeOtDatas'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_ot_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ot_excel_categories = OtCategory::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeOtDatas.create', compact('employees', 'ot_excel_categories'));
    }

    public function store(StoreEmployeeOtDataRequest $request)
    {
        $employeeOtData = EmployeeOtData::create($request->all());

        return redirect()->route('admin.employee-ot-datas.index');
    }

    public function edit(EmployeeOtData $employeeOtData)
    {
        abort_if(Gate::denies('employee_ot_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ot_excel_categories = OtCategory::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeOtData->load('employee', 'ot_excel_category');

        return view('admin.employeeOtDatas.edit', compact('employeeOtData', 'employees', 'ot_excel_categories'));
    }

    public function update(UpdateEmployeeOtDataRequest $request, EmployeeOtData $employeeOtData)
    {
        $employeeOtData->update($request->all());

        return redirect()->route('admin.employee-ot-datas.index');
    }

    public function show(EmployeeOtData $employeeOtData)
    {
        abort_if(Gate::denies('employee_ot_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtData->load('employee', 'ot_excel_category');

        return view('admin.employeeOtDatas.show', compact('employeeOtData'));
    }

    public function destroy(EmployeeOtData $employeeOtData)
    {
        abort_if(Gate::denies('employee_ot_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeOtData->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeOtDataRequest $request)
    {
        $employeeOtDatas = EmployeeOtData::find(request('ids'));

        foreach ($employeeOtDatas as $employeeOtData) {
            $employeeOtData->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
