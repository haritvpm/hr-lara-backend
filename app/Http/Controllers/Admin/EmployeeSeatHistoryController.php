<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmployeeSeatHistoryRequest;
use App\Http\Requests\StoreEmployeeSeatHistoryRequest;
use App\Http\Requests\UpdateEmployeeSeatHistoryRequest;
use App\Models\Employee;
use App\Models\EmployeeSeatHistory;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeSeatHistoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_seat_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSeatHistories = EmployeeSeatHistory::with(['seat', 'employee'])->get();

        return view('admin.employeeSeatHistories.index', compact('employeeSeatHistories'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_seat_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeSeatHistories.create', compact('employees', 'seats'));
    }

    public function store(StoreEmployeeSeatHistoryRequest $request)
    {
        $employeeSeatHistory = EmployeeSeatHistory::create($request->all());

        return redirect()->route('admin.employee-seat-histories.index');
    }

    public function edit(EmployeeSeatHistory $employeeSeatHistory)
    {
        abort_if(Gate::denies('employee_seat_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeSeatHistory->load('seat', 'employee');

        return view('admin.employeeSeatHistories.edit', compact('employeeSeatHistory', 'employees', 'seats'));
    }

    public function update(UpdateEmployeeSeatHistoryRequest $request, EmployeeSeatHistory $employeeSeatHistory)
    {
        $employeeSeatHistory->update($request->all());

        return redirect()->route('admin.employee-seat-histories.index');
    }

    public function show(EmployeeSeatHistory $employeeSeatHistory)
    {
        abort_if(Gate::denies('employee_seat_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSeatHistory->load('seat', 'employee');

        return view('admin.employeeSeatHistories.show', compact('employeeSeatHistory'));
    }

    public function destroy(EmployeeSeatHistory $employeeSeatHistory)
    {
        abort_if(Gate::denies('employee_seat_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSeatHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeSeatHistoryRequest $request)
    {
        $employeeSeatHistories = EmployeeSeatHistory::find(request('ids'));

        foreach ($employeeSeatHistories as $employeeSeatHistory) {
            $employeeSeatHistory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
