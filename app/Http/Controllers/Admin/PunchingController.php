<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePunchingRequest;
use App\Models\Employee;
use App\Models\Leaf;
use App\Models\Punching;
use App\Models\PunchingTrace;
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
            $query = Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave'])->select(sprintf('%s.*', (new Punching)->table));
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

            $table->editColumn('aadhaarid', function ($row) {
                return $row->aadhaarid ? $row->aadhaarid : '';
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
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
            });
            $table->editColumn('section', function ($row) {
                return $row->section ? $row->section : '';
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

            $table->editColumn('duration_sec', function ($row) {
                return $row->duration_sec ? $row->duration_sec : '';
            });
            $table->editColumn('grace_sec', function ($row) {
                return $row->grace_sec ? $row->grace_sec : '';
            });
            $table->editColumn('extra_sec', function ($row) {
                return $row->extra_sec ? $row->extra_sec : '';
            });
            $table->editColumn('duration_str', function ($row) {
                return $row->duration_str ? $row->duration_str : '';
            });
            $table->editColumn('grace_str', function ($row) {
                return $row->grace_str ? $row->grace_str : '';
            });
            $table->editColumn('extra_str', function ($row) {
                return $row->extra_str ? $row->extra_str : '';
            });
            $table->editColumn('punching_count', function ($row) {
                return $row->punching_count ? $row->punching_count : '';
            });
            $table->addColumn('leave_id', function ($row) {
                return $row->leave ? $row->leave_id : '';
            });

            $table->editColumn('leave.start_date', function ($row) {
                return $row->leave ? (is_string($row->leave) ? $row->leave : $row->leave->start_date) : '';
            });
            $table->editColumn('leave.end_date', function ($row) {
                return $row->leave ? (is_string($row->leave) ? $row->leave : $row->leave->end_date) : '';
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });
            $table->editColumn('finalized_by_controller', function ($row) {
                return $row->finalized_by_controller ? $row->finalized_by_controller : '';
            });
            $table->editColumn('ot_sitting_sec', function ($row) {
                return $row->ot_sitting_sec ? $row->ot_sitting_sec : '';
            });
            $table->editColumn('ot_nonsitting_sec', function ($row) {
                return $row->ot_nonsitting_sec ? $row->ot_nonsitting_sec : '';
            });
            $table->editColumn('hint', function ($row) {
                return $row->hint ? $row->hint : '';
            });

            $table->editColumn('grace_total_exceeded_one_hour', function ($row) {
                return $row->grace_total_exceeded_one_hour ? $row->grace_total_exceeded_one_hour : '';
            });
            $table->editColumn('computer_hint', function ($row) {
                return $row->computer_hint ? $row->computer_hint : '';
            });
            $table->editColumn('single_punch_type', function ($row) {
                return $row->single_punch_type ? $row->single_punch_type : '';
            });
            $table->editColumn('time_group', function ($row) {
                return $row->time_group ? $row->time_group : '';
            });
            $table->editColumn('is_unauthorised', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_unauthorised ? 'checked' : null) . '>';
            });
            $table->editColumn('single_punch_regularised_by', function ($row) {
                return $row->single_punch_regularised_by ? $row->single_punch_regularised_by : '';
            });
            $table->editColumn('duration_sec_needed', function ($row) {
                return $row->duration_sec_needed ? $row->duration_sec_needed : '';
            });
            $table->editColumn('flexi_time', function ($row) {
                return $row->flexi_time ? $row->flexi_time : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'punchin_trace', 'punchout_trace', 'leave', 'is_unauthorised']);

            return $table->make(true);
        }

        return view('admin.punchings.index');
    }

    public function edit(Punching $punching)
    {
        abort_if(Gate::denies('punching_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchin_traces = PunchingTrace::pluck('att_time', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchout_traces = PunchingTrace::pluck('att_time', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaves = Leaf::pluck('reason', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punching->load('employee', 'punchin_trace', 'punchout_trace', 'leave');

        return view('admin.punchings.edit', compact('employees', 'leaves', 'punchin_traces', 'punching', 'punchout_traces'));
    }

    public function update(UpdatePunchingRequest $request, Punching $punching)
    {
        $punching->update($request->all());

        return redirect()->route('admin.punchings.index');
    }

    public function show(Punching $punching)
    {
        abort_if(Gate::denies('punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punching->load('employee', 'punchin_trace', 'punchout_trace', 'leave');

        return view('admin.punchings.show', compact('punching'));
    }
}
