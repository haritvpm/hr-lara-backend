<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeToAcquittanceRequest;
use App\Http\Requests\StoreEmployeeToAcquittanceRequest;
use App\Http\Requests\UpdateEmployeeToAcquittanceRequest;
use App\Models\Acquittance;
use App\Models\Employee;
use App\Models\EmployeeToAcquittance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToAcquittanceController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_to_acquittance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToAcquittances = EmployeeToAcquittance::with(['employee', 'acquittance'])->get();

        return view('admin.employeeToAcquittances.index', compact('employeeToAcquittances'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_acquittance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $acquittances = Acquittance::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToAcquittances.create', compact('acquittances', 'employees'));
    }

    public function store(StoreEmployeeToAcquittanceRequest $request)
    {
        $employeeToAcquittance = EmployeeToAcquittance::create($request->all());

        return redirect()->route('admin.employee-to-acquittances.index');
    }

    public function edit(EmployeeToAcquittance $employeeToAcquittance)
    {
        abort_if(Gate::denies('employee_to_acquittance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $acquittances = Acquittance::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToAcquittance->load('employee', 'acquittance');

        return view('admin.employeeToAcquittances.edit', compact('acquittances', 'employeeToAcquittance', 'employees'));
    }

    public function update(UpdateEmployeeToAcquittanceRequest $request, EmployeeToAcquittance $employeeToAcquittance)
    {
        $employeeToAcquittance->update($request->all());

        return redirect()->route('admin.employee-to-acquittances.index');
    }

    public function show(EmployeeToAcquittance $employeeToAcquittance)
    {
        abort_if(Gate::denies('employee_to_acquittance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToAcquittance->load('employee', 'acquittance');

        return view('admin.employeeToAcquittances.show', compact('employeeToAcquittance'));
    }

    public function destroy(EmployeeToAcquittance $employeeToAcquittance)
    {
        abort_if(Gate::denies('employee_to_acquittance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToAcquittance->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeToAcquittanceRequest $request)
    {
        $employeeToAcquittances = EmployeeToAcquittance::find(request('ids'));

        foreach ($employeeToAcquittances as $employeeToAcquittance) {
            $employeeToAcquittance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
