<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeSectionHistoryRequest;
use App\Http\Requests\StoreEmployeeSectionHistoryRequest;
use App\Http\Requests\UpdateEmployeeSectionHistoryRequest;
use App\Models\Employee;
use App\Models\EmployeeSectionHistory;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeSectionHistoryController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_section_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSectionHistories = EmployeeSectionHistory::with(['employee', 'section_seat'])->get();

        return view('admin.employeeSectionHistories.index', compact('employeeSectionHistories'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_section_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $section_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeSectionHistories.create', compact('employees', 'section_seats'));
    }

    public function store(StoreEmployeeSectionHistoryRequest $request)
    {
        $employeeSectionHistory = EmployeeSectionHistory::create($request->all());

        return redirect()->route('admin.employee-section-histories.index');
    }

    public function edit(EmployeeSectionHistory $employeeSectionHistory)
    {
        abort_if(Gate::denies('employee_section_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $section_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeSectionHistory->load('employee', 'section_seat');

        return view('admin.employeeSectionHistories.edit', compact('employeeSectionHistory', 'employees', 'section_seats'));
    }

    public function update(UpdateEmployeeSectionHistoryRequest $request, EmployeeSectionHistory $employeeSectionHistory)
    {
        $employeeSectionHistory->update($request->all());

        return redirect()->route('admin.employee-section-histories.index');
    }

    public function show(EmployeeSectionHistory $employeeSectionHistory)
    {
        abort_if(Gate::denies('employee_section_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSectionHistory->load('employee', 'section_seat');

        return view('admin.employeeSectionHistories.show', compact('employeeSectionHistory'));
    }

    public function destroy(EmployeeSectionHistory $employeeSectionHistory)
    {
        abort_if(Gate::denies('employee_section_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSectionHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeSectionHistoryRequest $request)
    {
        $employeeSectionHistories = EmployeeSectionHistory::find(request('ids'));

        foreach ($employeeSectionHistories as $employeeSectionHistory) {
            $employeeSectionHistory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
