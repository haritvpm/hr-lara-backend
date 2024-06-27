<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeToFlexiRequest;
use App\Http\Requests\StoreEmployeeToFlexiRequest;
use App\Http\Requests\UpdateEmployeeToFlexiRequest;
use App\Models\Employee;
use App\Models\EmployeeToFlexi;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeToFlexiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeToFlexi::with(['employee'])->select(sprintf('%s.*', (new EmployeeToFlexi)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_to_section_access';
                $editGate      = 'employee_to_section_access';
                $deleteGate    = 'employee_to_section_access';
                $crudRoutePart = 'employee-to-flexis';

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

            $table->editColumn('employee.aadhaarid', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->aadhaarid) : '';
            });
            $table->editColumn('flexi_minutes', function ($row) {
                return $row->flexi_minutes ? $row->flexi_minutes : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.employeeToFlexis.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $employees = Employee::getEmployeesWithAadhaarDesig()->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToFlexis.create', compact('employees'));
    }

    public function store(StoreEmployeeToFlexiRequest $request)
    {
        $employeeToFlexi = EmployeeToFlexi::create($request->all());

        return redirect()->route('admin.employee-to-flexis.index');
    }

    public function edit(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $employees = Employee::getEmployeesWithAadhaarDesig()->prepend(trans('global.pleaseSelect'), '');


        $employeeToFlexi->load('employee');

        return view('admin.employeeToFlexis.edit', compact('employeeToFlexi', 'employees'));
    }

    public function update(UpdateEmployeeToFlexiRequest $request, EmployeeToFlexi $employeeToFlexi)
    {
        $employeeToFlexi->update($request->all());

        return redirect()->route('admin.employee-to-flexis.index');
    }

    public function show(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToFlexi->load('employee');

        return view('admin.employeeToFlexis.show', compact('employeeToFlexi'));
    }

    public function destroy(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToFlexi->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeToFlexiRequest $request)
    {
        $employeeToFlexis = EmployeeToFlexi::find(request('ids'));

        foreach ($employeeToFlexis as $employeeToFlexi) {
            $employeeToFlexi->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
