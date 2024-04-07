<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRequest;
use App\Http\Requests\UpdatePunchingRequest;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Leaf;
use App\Models\Punching;
use App\Models\PunchingTrace;
use App\Models\Section;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PunchingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('punching_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section'])->select(sprintf('%s.*', (new Punching)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'punching_show';
                $editGate      = 'punching_edit';
                $deleteGate    = 'punching_delete';
                $crudRoutePart = 'punchings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('employee_name', function ($row) {
                return $row->employee ? $row->employee->name : '';
            });

            $table->editColumn('employee.pen', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->pen) : '';
            });
            $table->editColumn('employee.aadhaarid', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->aadhaarid) : '';
            });
            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });
            $table->editColumn('flexi', function ($row) {
                return $row->flexi ? Punching::FLEXI_SELECT[$row->flexi] : '';
            });
            $table->editColumn('grace', function ($row) {
                return $row->grace ? $row->grace : '';
            });
            $table->editColumn('extra', function ($row) {
                return $row->extra ? $row->extra : '';
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });
            $table->editColumn('calc_complete', function ($row) {
                return $row->calc_complete ? $row->calc_complete : '';
            });
            $table->addColumn('punchin_trace_att_time', function ($row) {
                return $row->punchin_trace ? $row->punchin_trace->att_time : '';
            });

            $table->editColumn('punchin_trace.att_date', function ($row) {
                return $row->punchin_trace ? (is_string($row->punchin_trace) ? $row->punchin_trace : $row->punchin_trace->att_date) : '';
            });
            $table->addColumn('punchout_trace_att_time', function ($row) {
                return $row->punchout_trace ? $row->punchout_trace->att_time : '';
            });

            $table->editColumn('punchout_trace.att_date', function ($row) {
                return $row->punchout_trace ? (is_string($row->punchout_trace) ? $row->punchout_trace : $row->punchout_trace->att_date) : '';
            });
            $table->editColumn('ot_claimed_mins', function ($row) {
                return $row->ot_claimed_mins ? $row->ot_claimed_mins : '';
            });
            $table->editColumn('ot_extra_mins', function ($row) {
                return $row->ot_extra_mins ? $row->ot_extra_mins : '';
            });
            $table->editColumn('punching_status', function ($row) {
                return $row->punching_status ? $row->punching_status : '';
            });
            $table->addColumn('leave_reason', function ($row) {
                return $row->leave ? $row->leave->reason : '';
            });

            $table->editColumn('leave.start_date', function ($row) {
                return $row->leave ? (is_string($row->leave) ? $row->leave : $row->leave->start_date) : '';
            });
            $table->editColumn('leave.end_date', function ($row) {
                return $row->leave ? (is_string($row->leave) ? $row->leave : $row->leave->end_date) : '';
            });
            $table->addColumn('designation_designation', function ($row) {
                return $row->designation ? $row->designation->designation : '';
            });

            $table->addColumn('section_name', function ($row) {
                return $row->section ? $row->section->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section']);

            return $table->make(true);
        }

        return view('admin.punchings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('punching_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchin_traces = PunchingTrace::pluck('att_time', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchout_traces = PunchingTrace::pluck('att_time', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaves = Leaf::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.punchings.create', compact('designations', 'employees', 'leaves', 'punchin_traces', 'punchout_traces', 'sections'));
    }

    public function store(StorePunchingRequest $request)
    {
        $punching = Punching::create($request->all());

        return redirect()->route('admin.punchings.index');
    }

    public function edit(Punching $punching)
    {
        abort_if(Gate::denies('punching_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchin_traces = PunchingTrace::pluck('att_time', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchout_traces = PunchingTrace::pluck('att_time', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaves = Leaf::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punching->load('employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section');

        return view('admin.punchings.edit', compact('designations', 'employees', 'leaves', 'punchin_traces', 'punching', 'punchout_traces', 'sections'));
    }

    public function update(UpdatePunchingRequest $request, Punching $punching)
    {
        $punching->update($request->all());

        return redirect()->route('admin.punchings.index');
    }

    public function show(Punching $punching)
    {
        abort_if(Gate::denies('punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punching->load('employee', 'punchin_trace', 'punchout_trace', 'leave', 'designation', 'section');

        return view('admin.punchings.show', compact('punching'));
    }
}
