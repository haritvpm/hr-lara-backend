<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeAtSeatRequest;
use App\Http\Requests\StoreEmployeeAtSeatRequest;
use App\Http\Requests\UpdateEmployeeAtSeatRequest;
use App\Models\Employee;
use App\Models\EmployeeAtSeat;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAtSeatController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_at_seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAtSeats = EmployeeAtSeat::with(['employee', 'seat'])->get();

        return view('admin.employeeAtSeats.index', compact('employeeAtSeats'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_at_seat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeAtSeats.create', compact('employees', 'seats'));
    }

    public function store(StoreEmployeeAtSeatRequest $request)
    {
        $employeeAtSeat = EmployeeAtSeat::create($request->all());

        return redirect()->route('admin.employee-at-seats.index');
    }

    public function edit(EmployeeAtSeat $employeeAtSeat)
    {
        abort_if(Gate::denies('employee_at_seat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeAtSeat->load('employee', 'seat');

        return view('admin.employeeAtSeats.edit', compact('employeeAtSeat', 'employees', 'seats'));
    }

    public function update(UpdateEmployeeAtSeatRequest $request, EmployeeAtSeat $employeeAtSeat)
    {
        $employeeAtSeat->update($request->all());

        return redirect()->route('admin.employee-at-seats.index');
    }

    public function show(EmployeeAtSeat $employeeAtSeat)
    {
        abort_if(Gate::denies('employee_at_seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAtSeat->load('employee', 'seat');

        return view('admin.employeeAtSeats.show', compact('employeeAtSeat'));
    }

    public function destroy(EmployeeAtSeat $employeeAtSeat)
    {
        abort_if(Gate::denies('employee_at_seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeAtSeat->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeAtSeatRequest $request)
    {
        $employeeAtSeats = EmployeeAtSeat::find(request('ids'));

        foreach ($employeeAtSeats as $employeeAtSeat) {
            $employeeAtSeat->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
