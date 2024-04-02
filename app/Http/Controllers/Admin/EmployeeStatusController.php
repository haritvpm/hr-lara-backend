<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeStatusRequest;
use App\Http\Requests\StoreEmployeeStatusRequest;
use App\Http\Requests\UpdateEmployeeStatusRequest;
use App\Models\EmployeeStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeStatusController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeStatuses = EmployeeStatus::all();

        return view('admin.employeeStatuses.index', compact('employeeStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeStatuses.create');
    }

    public function store(StoreEmployeeStatusRequest $request)
    {
        $employeeStatus = EmployeeStatus::create($request->all());

        return redirect()->route('admin.employee-statuses.index');
    }

    public function edit(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeStatuses.edit', compact('employeeStatus'));
    }

    public function update(UpdateEmployeeStatusRequest $request, EmployeeStatus $employeeStatus)
    {
        $employeeStatus->update($request->all());

        return redirect()->route('admin.employee-statuses.index');
    }

    public function show(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employeeStatuses.show', compact('employeeStatus'));
    }

    public function destroy(EmployeeStatus $employeeStatus)
    {
        abort_if(Gate::denies('employee_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeStatusRequest $request)
    {
        $employeeStatuses = EmployeeStatus::find(request('ids'));

        foreach ($employeeStatuses as $employeeStatus) {
            $employeeStatus->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
