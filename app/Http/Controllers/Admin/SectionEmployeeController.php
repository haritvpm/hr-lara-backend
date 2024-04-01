<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySectionEmployeeRequest;
use App\Http\Requests\StoreSectionEmployeeRequest;
use App\Http\Requests\UpdateSectionEmployeeRequest;
use App\Models\AttendanceBook;
use App\Models\Employee;
use App\Models\Section;
use App\Models\SectionEmployee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SectionEmployeeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('section_employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sectionEmployees = SectionEmployee::with(['employee', 'section', 'attendance_book'])->get();

        return view('admin.sectionEmployees.index', compact('sectionEmployees'));
    }

    public function create()
    {
        abort_if(Gate::denies('section_employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance_books = AttendanceBook::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sectionEmployees.create', compact('attendance_books', 'employees', 'sections'));
    }

    public function store(StoreSectionEmployeeRequest $request)
    {
        $sectionEmployee = SectionEmployee::create($request->all());

        return redirect()->route('admin.section-employees.index');
    }

    public function edit(SectionEmployee $sectionEmployee)
    {
        abort_if(Gate::denies('section_employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance_books = AttendanceBook::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sectionEmployee->load('employee', 'section', 'attendance_book');

        return view('admin.sectionEmployees.edit', compact('attendance_books', 'employees', 'sectionEmployee', 'sections'));
    }

    public function update(UpdateSectionEmployeeRequest $request, SectionEmployee $sectionEmployee)
    {
        $sectionEmployee->update($request->all());

        return redirect()->route('admin.section-employees.index');
    }

    public function show(SectionEmployee $sectionEmployee)
    {
        abort_if(Gate::denies('section_employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sectionEmployee->load('employee', 'section', 'attendance_book');

        return view('admin.sectionEmployees.show', compact('sectionEmployee'));
    }

    public function destroy(SectionEmployee $sectionEmployee)
    {
        abort_if(Gate::denies('section_employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sectionEmployee->delete();

        return back();
    }

    public function massDestroy(MassDestroySectionEmployeeRequest $request)
    {
        $sectionEmployees = SectionEmployee::find(request('ids'));

        foreach ($sectionEmployees as $sectionEmployee) {
            $sectionEmployee->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
