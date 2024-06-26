<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Section;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\AttendanceBook;
use App\Models\EmployeeToSection;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreEmployeeToSectionRequest;
use App\Http\Requests\UpdateEmployeeToSectionRequest;
use App\Http\Requests\MassDestroyEmployeeToSectionRequest;

class EmployeeToSectionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmployeeToSection::with(['employee', 'section', 'attendance_book'])->select(sprintf('%s.*', (new EmployeeToSection)->table));
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
            $table->addColumn('section_name', function ($row) {
                return $row->section ? $row->section->name : '';
            });

            $table->addColumn('attendance_book_title', function ($row) {
                return $row->attendance_book ? $row->attendance_book->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'section', 'attendance_book']);

            return $table->make(true);
        }

        return view('admin.employeeToSections.index');
    }

    public function create()
    {
        abort_if(Gate::denies('employee_to_section_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employees = Employee::getEmployeesWithAadhaarDesig()->prepend(trans('global.pleaseSelect'), '');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance_books = AttendanceBook::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeToSections.create', compact('attendance_books', 'employees', 'sections'));
    }

    public function store(StoreEmployeeToSectionRequest $request)
    {

        //check if employee is already assigned to some other section, with start date and no end date, if yes then return back with error message


        $prevSectionNotEnded = EmployeeToSection::where('employee_id', $request->employee_id)
            ->wherenull('end_date')->first();
        if($prevSectionNotEnded){
            //\Session::flash('message-danger', 'Employee is already assigned to some other section');
            return back()->withErrors(['error'=> 'Employee is already assigned to some other section'])->withInput();
        }
        $employeeToSectionExisting = EmployeeToSection::where('employee_id', $request->employee_id)
        ->duringPeriod($request->start_date, $request->start_date)
        ->first();
        if ($employeeToSectionExisting) {
            //\Session::flash('message-danger', 'Employee period overlaps with another posting');
            return back()->withErrors(['error'=> 'Employee period overlaps with another posting'])->withInput();
        }

        //check if end date is before start date
        if($request->end_date && $request->start_date && Carbon::parse($request->start_date)->gt(Carbon::parse($request->end_date))){
            return back()->withErrors(['error'=> 'End date should be after start date'])->withInput();
        }


        $employeeToSection = EmployeeToSection::create($request->all());

        return redirect()->route('admin.employee-to-sections.index');
    }

    public function edit(EmployeeToSection $employeeToSection)
    {
        abort_if(Gate::denies('employee_to_section_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::getEmployeesWithAadhaar()->prepend(trans('global.pleaseSelect'), '');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance_books = AttendanceBook::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeToSection->load('employee', 'section', 'attendance_book');

        return view('admin.employeeToSections.edit', compact('attendance_books', 'employeeToSection', 'employees', 'sections'));
    }

    public function update(UpdateEmployeeToSectionRequest $request, EmployeeToSection $employeeToSection)
    {

        $employeeToSectionExisting = EmployeeToSection::where('employee_id', $request->employee_id)
        ->duringPeriod($request->start_date, $request->start_date)
        ->first();
        if ($employeeToSectionExisting && $employeeToSectionExisting->id != $employeeToSection->id) {
            //\Session::flash('message-danger', 'Employee period overlaps with another posting');
            return back()->withErrors(['error'=> 'Employee period overlaps with another posting'])->withInput();
        }

        //check if end date is before start date
        if($request->end_date && $request->start_date && Carbon::parse($request->start_date)->gt(Carbon::parse($request->end_date))){
            return back()->withErrors(['error'=> 'End date should be after start date'])->withInput();
        }


        $employeeToSection->update($request->all());

        return redirect()->route('admin.employee-to-sections.index');
    }

    public function show(EmployeeToSection $employeeToSection)
    {
        abort_if(Gate::denies('employee_to_section_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSection->load('employee', 'section', 'attendance_book');

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
