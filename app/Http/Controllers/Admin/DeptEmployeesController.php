<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDeptEmployeeRequest;
use App\Http\Requests\StoreDeptEmployeeRequest;
use App\Http\Requests\UpdateDeptEmployeeRequest;
use App\Models\DeptDesignation;
use App\Models\DeptEmployee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeptEmployeesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('dept_employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptEmployees = DeptEmployee::with(['designation'])->get();

        return view('admin.deptEmployees.index', compact('deptEmployees'));
    }

    public function create()
    {
        abort_if(Gate::denies('dept_employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = DeptDesignation::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.deptEmployees.create', compact('designations'));
    }

    public function store(StoreDeptEmployeeRequest $request)
    {
        $deptEmployee = DeptEmployee::create($request->all());

        return redirect()->route('admin.dept-employees.index');
    }

    public function edit(DeptEmployee $deptEmployee)
    {
        abort_if(Gate::denies('dept_employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = DeptDesignation::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deptEmployee->load('designation');

        return view('admin.deptEmployees.edit', compact('deptEmployee', 'designations'));
    }

    public function update(UpdateDeptEmployeeRequest $request, DeptEmployee $deptEmployee)
    {
        $deptEmployee->update($request->all());

        return redirect()->route('admin.dept-employees.index');
    }

    public function show(DeptEmployee $deptEmployee)
    {
        abort_if(Gate::denies('dept_employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptEmployee->load('designation');

        return view('admin.deptEmployees.show', compact('deptEmployee'));
    }

    public function destroy(DeptEmployee $deptEmployee)
    {
        abort_if(Gate::denies('dept_employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptEmployee->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeptEmployeeRequest $request)
    {
        $deptEmployees = DeptEmployee::find(request('ids'));

        foreach ($deptEmployees as $deptEmployee) {
            $deptEmployee->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
