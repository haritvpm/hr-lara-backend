<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRequest;
use App\Http\Requests\UpdatePunchingRequest;
use App\Models\Employee;
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
            $query = Punching::with(['employee', 'punchin_trace', 'punchout_trace'])->select(sprintf('%s.*', (new Punching)->table));
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
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
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

            $table->rawColumns(['actions', 'placeholder', 'employee', 'punchin_trace', 'punchout_trace']);

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

        return view('admin.punchings.create', compact('employees', 'punchin_traces', 'punchout_traces'));
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

        $punching->load('employee', 'punchin_trace', 'punchout_trace');

        return view('admin.punchings.edit', compact('employees', 'punchin_traces', 'punching', 'punchout_traces'));
    }

    public function update(UpdatePunchingRequest $request, Punching $punching)
    {
        $punching->update($request->all());

        return redirect()->route('admin.punchings.index');
    }

    public function show(Punching $punching)
    {
        abort_if(Gate::denies('punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punching->load('employee', 'punchin_trace', 'punchout_trace');

        return view('admin.punchings.show', compact('punching'));
    }
}