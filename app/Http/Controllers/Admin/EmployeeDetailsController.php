<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeDetailRequest;
use App\Http\Requests\StoreEmployeeDetailRequest;
use App\Http\Requests\UpdateEmployeeDetailRequest;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeDetailsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDetails = EmployeeDetail::with(['employee'])->get();

        return view('admin.employeeDetails.index', compact('employeeDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeDetails.create', compact('employees'));
    }

    public function store(StoreEmployeeDetailRequest $request)
    {
        $employeeDetail = EmployeeDetail::create($request->all());

        return redirect()->route('admin.employee-details.index');
    }

    public function edit(EmployeeDetail $employeeDetail)
    {
        abort_if(Gate::denies('employee_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeDetail->load('employee');

        return view('admin.employeeDetails.edit', compact('employeeDetail', 'employees'));
    }

    public function update(UpdateEmployeeDetailRequest $request, EmployeeDetail $employeeDetail)
    {
        $employeeDetail->update($request->all());

        return redirect()->route('admin.employee-details.index');
    }

    public function show(EmployeeDetail $employeeDetail)
    {
        abort_if(Gate::denies('employee_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDetail->load('employee');

        return view('admin.employeeDetails.show', compact('employeeDetail'));
    }

    public function destroy(EmployeeDetail $employeeDetail)
    {
        abort_if(Gate::denies('employee_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeDetailRequest $request)
    {
        $employeeDetails = EmployeeDetail::find(request('ids'));

        foreach ($employeeDetails as $employeeDetail) {
            $employeeDetail->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
