<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeToSeatRequest;
use App\Http\Requests\StoreEmployeeToSeatRequest;
use App\Http\Requests\UpdateEmployeeToSeatRequest;
use App\Models\Employee;
use App\Models\EmployeeToSeat;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeToSeatController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_to_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeToSeat::with(['employee', 'seat'])->select(sprintf('%s.*', (new EmployeeToSeat)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_to_seat_show';
                $editGate      = 'employee_to_seat_edit';
                $deleteGate    = 'employee_to_seat_delete';
                $crudRoutePart = 'employee-to-seats';

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

            $table->addColumn('seat_title', function ($row) {
                return $row->seat ? $row->seat->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'seat']);

            return $table->make(true);
        }

        return view('admin.employeeToSeats.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_seat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::getEmployeesWithAadhaarDesig()->prepend(trans('global.pleaseSelect'), '');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToSeats.create', compact('employees', 'seats'));
    }

    public function store(StoreEmployeeToSeatRequest $request)
    {
        $employeeToSeat = EmployeeToSeat::create($request->all());

        return redirect()->route('admin.employee-to-seats.index');
    }

    public function edit(EmployeeToSeat $employeeToSeat)
    {
        abort_if(Gate::denies('employee_to_seat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::getEmployeesWithAadhaarDesig()->prepend(trans('global.pleaseSelect'), '');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToSeat->load('employee', 'seat');

        return view('admin.employeeToSeats.edit', compact('employeeToSeat', 'employees', 'seats'));
    }

    public function update(UpdateEmployeeToSeatRequest $request, EmployeeToSeat $employeeToSeat)
    {
        $employeeToSeat->update($request->all());

        return redirect()->route('admin.employee-to-seats.index');
    }

    public function show(EmployeeToSeat $employeeToSeat)
    {
        abort_if(Gate::denies('employee_to_seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSeat->load('employee', 'seat');

        return view('admin.employeeToSeats.show', compact('employeeToSeat'));
    }

    public function destroy(EmployeeToSeat $employeeToSeat)
    {
        abort_if(Gate::denies('employee_to_seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSeat->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeToSeatRequest $request)
    {
        $employeeToSeats = EmployeeToSeat::find(request('ids'));

        foreach ($employeeToSeats as $employeeToSeat) {
            $employeeToSeat->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
