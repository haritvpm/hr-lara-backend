<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRegisterRequest;
use App\Http\Requests\UpdatePunchingRegisterRequest;
use App\Models\Employee;
use App\Models\PunchingRegister;
use App\Models\PunchingTrace;
use App\Models\SuccessPunching;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PunchingRegisterController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('punching_register_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PunchingRegister::with(['employee', 'success_punching', 'punching_traces'])->select(sprintf('%s.*', (new PunchingRegister)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'punching_register_show';
                $editGate      = 'punching_register_edit';
                $deleteGate    = 'punching_register_delete';
                $crudRoutePart = 'punching-registers';

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
                return $row->flexi ? PunchingRegister::FLEXI_SELECT[$row->flexi] : '';
            });
            $table->editColumn('grace_min', function ($row) {
                return $row->grace_min ? $row->grace_min : '';
            });
            $table->editColumn('extra_min', function ($row) {
                return $row->extra_min ? $row->extra_min : '';
            });
            $table->addColumn('success_punching_date', function ($row) {
                return $row->success_punching ? $row->success_punching->date : '';
            });

            $table->editColumn('punching_trace', function ($row) {
                $labels = [];
                foreach ($row->punching_traces as $punching_trace) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $punching_trace->att_date);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'success_punching', 'punching_trace']);

            return $table->make(true);
        }

        return view('admin.punchingRegisters.index');
    }

    public function create()
    {
        abort_if(Gate::denies('punching_register_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $success_punchings = SuccessPunching::pluck('date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punching_traces = PunchingTrace::pluck('att_date', 'id');

        return view('admin.punchingRegisters.create', compact('employees', 'punching_traces', 'success_punchings'));
    }

    public function store(StorePunchingRegisterRequest $request)
    {
        $punchingRegister = PunchingRegister::create($request->all());
        $punchingRegister->punching_traces()->sync($request->input('punching_traces', []));

        return redirect()->route('admin.punching-registers.index');
    }

    public function edit(PunchingRegister $punchingRegister)
    {
        abort_if(Gate::denies('punching_register_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $success_punchings = SuccessPunching::pluck('date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punching_traces = PunchingTrace::pluck('att_date', 'id');

        $punchingRegister->load('employee', 'success_punching', 'punching_traces');

        return view('admin.punchingRegisters.edit', compact('employees', 'punchingRegister', 'punching_traces', 'success_punchings'));
    }

    public function update(UpdatePunchingRegisterRequest $request, PunchingRegister $punchingRegister)
    {
        $punchingRegister->update($request->all());
        $punchingRegister->punching_traces()->sync($request->input('punching_traces', []));

        return redirect()->route('admin.punching-registers.index');
    }

    public function show(PunchingRegister $punchingRegister)
    {
        abort_if(Gate::denies('punching_register_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punchingRegister->load('employee', 'success_punching', 'punching_traces');

        return view('admin.punchingRegisters.show', compact('punchingRegister'));
    }
}
