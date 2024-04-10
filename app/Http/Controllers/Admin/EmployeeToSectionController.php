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
use Yajra\DataTables\Facades\DataTables;

class EmployeeToSectionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeToSection::with(['employee', 'section_seat', 'attendance_book'])->select(sprintf('%s.*', (new EmployeeToSection)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'employee_to_section_show';
                $editGate      = 'employee_to_section_edit';
                $deleteGate    = 'employee_to_section_delete';
                $crudRoutePart = 'employee-to-sections';

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
            $table->addColumn('section_seat_title', function ($row) {
                return $row->section_seat ? $row->section_seat->title : '';
            });

            $table->addColumn('attendance_book_title', function ($row) {
                return $row->attendance_book ? $row->attendance_book->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'section_seat', 'attendance_book']);

            return $table->make(true);
        }

        return view('admin.employeeToSections.index');
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
