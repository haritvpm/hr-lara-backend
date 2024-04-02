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

class EmployeeToSeatController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_to_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSeats = EmployeeToSeat::with(['seat', 'employee'])->get();

        return view('admin.employeeToSeats.index', compact('employeeToSeats'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_seat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

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

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToSeat->load('seat', 'employee');

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

        $employeeToSeat->load('seat', 'employee');

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
