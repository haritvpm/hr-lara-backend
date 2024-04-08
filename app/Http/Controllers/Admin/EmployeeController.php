<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Employee::query()->select(sprintf('%s.*', (new Employee)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_show';
                $editGate      = 'employee_edit';
                $deleteGate    = 'employee_delete';
                $crudRoutePart = 'employees';

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
            $table->editColumn('srismt', function ($row) {
                return $row->srismt ? Employee::SRISMT_SELECT[$row->srismt] : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('name_mal', function ($row) {
                return $row->name_mal ? $row->name_mal : '';
            });
            $table->editColumn('pen', function ($row) {
                return $row->pen ? $row->pen : '';
            });
            $table->editColumn('aadhaarid', function ($row) {
                return $row->aadhaarid ? $row->aadhaarid : '';
            });
            $table->editColumn('employee_type', function ($row) {
                return $row->employee_type ? Employee::EMPLOYEE_TYPE_SELECT[$row->employee_type] : '';
            });
            $table->editColumn('desig_display', function ($row) {
                return $row->desig_display ? $row->desig_display : '';
            });
            $table->editColumn('pan', function ($row) {
                return $row->pan ? $row->pan : '';
            });
            $table->editColumn('has_punching', function ($row) {
                return $row->has_punching ? $row->has_punching : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Employee::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('is_shift', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_shift ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_shift']);

            return $table->make(true);
        }

        return view('admin.employees.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employees.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employees.edit', compact('employee'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        return redirect()->route('admin.employees.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('employeeEmployeeToDesignations');

        return view('admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        $employees = Employee::find(request('ids'));

        foreach ($employees as $employee) {
            $employee->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function aebasfetch($request)
    {
        (new EmployeeService())->syncEmployeeDataFromAebas();

    }
    
}
