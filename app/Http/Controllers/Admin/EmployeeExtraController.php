<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeExtraRequest;
use App\Http\Requests\StoreEmployeeExtraRequest;
use App\Http\Requests\UpdateEmployeeExtraRequest;
use App\Models\Employee;
use App\Models\EmployeeExtra;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeExtraController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeExtras = EmployeeExtra::with(['employee'])->get();

        return view('admin.employeeExtras.index', compact('employeeExtras'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeExtras.create', compact('employees'));
    }

    public function store(StoreEmployeeExtraRequest $request)
    {
        $employeeExtra = EmployeeExtra::create($request->all());

        return redirect()->route('admin.employee-extras.index');
    }

    public function edit(EmployeeExtra $employeeExtra)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeExtra->load('employee');

        return view('admin.employeeExtras.edit', compact('employeeExtra', 'employees'));
    }

    public function update(UpdateEmployeeExtraRequest $request, EmployeeExtra $employeeExtra)
    {
        $employeeExtra->update($request->all());

        return redirect()->route('admin.employee-extras.index');
    }

    public function show(EmployeeExtra $employeeExtra)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeExtra->load('employee');

        return view('admin.employeeExtras.show', compact('employeeExtra'));
    }

    public function destroy(EmployeeExtra $employeeExtra)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeExtra->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeExtraRequest $request)
    {
        $employeeExtras = EmployeeExtra::find(request('ids'));

        foreach ($employeeExtras as $employeeExtra) {
            $employeeExtra->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
