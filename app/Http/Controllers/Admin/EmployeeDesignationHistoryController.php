<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeDesignationHistoryRequest;
use App\Http\Requests\StoreEmployeeDesignationHistoryRequest;
use App\Http\Requests\UpdateEmployeeDesignationHistoryRequest;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeDesignationHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeDesignationHistoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_designation_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDesignationHistories = EmployeeDesignationHistory::with(['employee', 'designation'])->get();

        return view('admin.employeeDesignationHistories.index', compact('employeeDesignationHistories'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_designation_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeDesignationHistories.create', compact('designations', 'employees'));
    }

    public function store(StoreEmployeeDesignationHistoryRequest $request)
    {
        $employeeDesignationHistory = EmployeeDesignationHistory::create($request->all());

        return redirect()->route('admin.employee-designation-histories.index');
    }

    public function edit(EmployeeDesignationHistory $employeeDesignationHistory)
    {
        abort_if(Gate::denies('employee_designation_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeDesignationHistory->load('employee', 'designation');

        return view('admin.employeeDesignationHistories.edit', compact('designations', 'employeeDesignationHistory', 'employees'));
    }

    public function update(UpdateEmployeeDesignationHistoryRequest $request, EmployeeDesignationHistory $employeeDesignationHistory)
    {
        $employeeDesignationHistory->update($request->all());

        return redirect()->route('admin.employee-designation-histories.index');
    }

    public function show(EmployeeDesignationHistory $employeeDesignationHistory)
    {
        abort_if(Gate::denies('employee_designation_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDesignationHistory->load('employee', 'designation');

        return view('admin.employeeDesignationHistories.show', compact('employeeDesignationHistory'));
    }

    public function destroy(EmployeeDesignationHistory $employeeDesignationHistory)
    {
        abort_if(Gate::denies('employee_designation_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDesignationHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeDesignationHistoryRequest $request)
    {
        $employeeDesignationHistories = EmployeeDesignationHistory::find(request('ids'));

        foreach ($employeeDesignationHistories as $employeeDesignationHistory) {
            $employeeDesignationHistory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
