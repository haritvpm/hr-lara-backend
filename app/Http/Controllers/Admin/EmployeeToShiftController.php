<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeToShiftRequest;
use App\Http\Requests\StoreEmployeeToShiftRequest;
use App\Http\Requests\UpdateEmployeeToShiftRequest;
use App\Models\Employee;
use App\Models\EmployeeToShift;
use App\Models\Shift;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToShiftController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_to_shift_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToShifts = EmployeeToShift::with(['employee', 'shift'])->get();

        return view('admin.employeeToShifts.index', compact('employeeToShifts'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_shift_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shifts = Shift::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToShifts.create', compact('employees', 'shifts'));
    }

    public function store(StoreEmployeeToShiftRequest $request)
    {
        $employeeToShift = EmployeeToShift::create($request->all());

        return redirect()->route('admin.employee-to-shifts.index');
    }

    public function edit(EmployeeToShift $employeeToShift)
    {
        abort_if(Gate::denies('employee_to_shift_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shifts = Shift::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToShift->load('employee', 'shift');

        return view('admin.employeeToShifts.edit', compact('employeeToShift', 'employees', 'shifts'));
    }

    public function update(UpdateEmployeeToShiftRequest $request, EmployeeToShift $employeeToShift)
    {
        $employeeToShift->update($request->all());

        return redirect()->route('admin.employee-to-shifts.index');
    }

    public function show(EmployeeToShift $employeeToShift)
    {
        abort_if(Gate::denies('employee_to_shift_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToShift->load('employee', 'shift');

        return view('admin.employeeToShifts.show', compact('employeeToShift'));
    }

    public function destroy(EmployeeToShift $employeeToShift)
    {
        abort_if(Gate::denies('employee_to_shift_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToShift->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeToShiftRequest $request)
    {
        $employeeToShifts = EmployeeToShift::find(request('ids'));

        foreach ($employeeToShifts as $employeeToShift) {
            $employeeToShift->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
