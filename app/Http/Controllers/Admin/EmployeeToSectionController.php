<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeToSectionRequest;
use App\Http\Requests\StoreEmployeeToSectionRequest;
use App\Http\Requests\UpdateEmployeeToSectionRequest;
use App\Models\AttendanceBook;
use App\Models\Employee;
use App\Models\EmployeeToSection;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToSectionController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSections = EmployeeToSection::with(['employee', 'section_seat', 'attendance_book'])->get();

        return view('admin.employeeToSections.index', compact('employeeToSections'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_section_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $section_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance_books = AttendanceBook::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToSections.create', compact('attendance_books', 'employees', 'section_seats'));
    }

    public function store(StoreEmployeeToSectionRequest $request)
    {
        $employeeToSection = EmployeeToSection::create($request->all());

        return redirect()->route('admin.employee-to-sections.index');
    }

    public function edit(EmployeeToSection $employeeToSection)
    {
        abort_if(Gate::denies('employee_to_section_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $section_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance_books = AttendanceBook::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToSection->load('employee', 'section_seat', 'attendance_book');

        return view('admin.employeeToSections.edit', compact('attendance_books', 'employeeToSection', 'employees', 'section_seats'));
    }

    public function update(UpdateEmployeeToSectionRequest $request, EmployeeToSection $employeeToSection)
    {
        $employeeToSection->update($request->all());

        return redirect()->route('admin.employee-to-sections.index');
    }

    public function show(EmployeeToSection $employeeToSection)
    {
        abort_if(Gate::denies('employee_to_section_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSection->load('employee', 'section_seat', 'attendance_book');

        return view('admin.employeeToSections.show', compact('employeeToSection'));
    }

    public function destroy(EmployeeToSection $employeeToSection)
    {
        abort_if(Gate::denies('employee_to_section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSection->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeToSectionRequest $request)
    {
        $employeeToSections = EmployeeToSection::find(request('ids'));

        foreach ($employeeToSections as $employeeToSection) {
            $employeeToSection->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
