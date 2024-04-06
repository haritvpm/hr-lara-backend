<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeToDesignationRequest;
use App\Http\Requests\StoreEmployeeToDesignationRequest;
use App\Http\Requests\UpdateEmployeeToDesignationRequest;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeToDesignation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeToDesignationController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_to_designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeToDesignation::with(['employee', 'designation'])->select(sprintf('%s.*', (new EmployeeToDesignation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_to_designation_show';
                $editGate      = 'employee_to_designation_edit';
                $deleteGate    = 'employee_to_designation_delete';
                $crudRoutePart = 'employee-to-designations';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('employee_name', function ($row) {
                return $row->employee ? $row->employee->name : '';
            });

            $table->editColumn('employee.pen', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->pen) : '';
            });
            $table->addColumn('designation_designation', function ($row) {
                return $row->designation ? $row->designation->designation : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'designation']);

            return $table->make(true);
        }

        return view('admin.employeeToDesignations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToDesignations.create', compact('designations', 'employees'));
    }

    public function store(StoreEmployeeToDesignationRequest $request)
    {
        $employeeToDesignation = EmployeeToDesignation::create($request->all());

        return redirect()->route('admin.employee-to-designations.index');
    }

    public function edit(EmployeeToDesignation $employeeToDesignation)
    {
        abort_if(Gate::denies('employee_to_designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToDesignation->load('employee', 'designation');

        return view('admin.employeeToDesignations.edit', compact('designations', 'employeeToDesignation', 'employees'));
    }

    public function update(UpdateEmployeeToDesignationRequest $request, EmployeeToDesignation $employeeToDesignation)
    {
        $employeeToDesignation->update($request->all());

        return redirect()->route('admin.employee-to-designations.index');
    }

    public function show(EmployeeToDesignation $employeeToDesignation)
    {
        abort_if(Gate::denies('employee_to_designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToDesignation->load('employee', 'designation');

        return view('admin.employeeToDesignations.show', compact('employeeToDesignation'));
    }

    public function destroy(EmployeeToDesignation $employeeToDesignation)
    {
        abort_if(Gate::denies('employee_to_designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToDesignation->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeToDesignationRequest $request)
    {
        $employeeToDesignations = EmployeeToDesignation::find(request('ids'));

        foreach ($employeeToDesignations as $employeeToDesignation) {
            $employeeToDesignation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
