<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOvertimeRequest;
use App\Http\Requests\StoreOvertimeRequest;
use App\Http\Requests\UpdateOvertimeRequest;
use App\Models\Employee;
use App\Models\OtForm;
use App\Models\Overtime;
use App\Models\PunchingTrace;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OvertimeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('overtime_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Overtime::with(['employee', 'form', 'punchin', 'punchout'])->select(sprintf('%s.*', (new Overtime)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'overtime_show';
                $editGate      = 'overtime_edit';
                $deleteGate    = 'overtime_delete';
                $crudRoutePart = 'overtimes';

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

            $table->editColumn('employee.pen', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->pen) : '';
            });
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
            });
            $table->editColumn('from', function ($row) {
                return $row->from ? $row->from : '';
            });
            $table->editColumn('to', function ($row) {
                return $row->to ? $row->to : '';
            });
            $table->editColumn('count', function ($row) {
                return $row->count ? $row->count : '';
            });
            $table->addColumn('form_creator', function ($row) {
                return $row->form ? $row->form->creator : '';
            });

            $table->editColumn('form.owner', function ($row) {
                return $row->form ? (is_string($row->form) ? $row->form : $row->form->owner) : '';
            });
            $table->addColumn('punchin_att_date', function ($row) {
                return $row->punchin ? $row->punchin->att_date : '';
            });

            $table->editColumn('punchin.att_date', function ($row) {
                return $row->punchin ? (is_string($row->punchin) ? $row->punchin : $row->punchin->att_date) : '';
            });
            $table->editColumn('punchin.att_time', function ($row) {
                return $row->punchin ? (is_string($row->punchin) ? $row->punchin : $row->punchin->att_time) : '';
            });
            $table->addColumn('punchout_att_date', function ($row) {
                return $row->punchout ? $row->punchout->att_date : '';
            });

            $table->editColumn('punchout.att_date', function ($row) {
                return $row->punchout ? (is_string($row->punchout) ? $row->punchout : $row->punchout->att_date) : '';
            });
            $table->editColumn('punchout.att_time', function ($row) {
                return $row->punchout ? (is_string($row->punchout) ? $row->punchout : $row->punchout->att_time) : '';
            });
            $table->editColumn('slots', function ($row) {
                return $row->slots ? $row->slots : '';
            });
            $table->editColumn('has_punching', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->has_punching ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'form', 'punchin', 'punchout', 'has_punching']);

            return $table->make(true);
        }

        return view('admin.overtimes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('overtime_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = OtForm::pluck('creator', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchins = PunchingTrace::pluck('att_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchouts = PunchingTrace::pluck('att_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.overtimes.create', compact('employees', 'forms', 'punchins', 'punchouts'));
    }

    public function store(StoreOvertimeRequest $request)
    {
        $overtime = Overtime::create($request->all());

        return redirect()->route('admin.overtimes.index');
    }

    public function edit(Overtime $overtime)
    {
        abort_if(Gate::denies('overtime_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = OtForm::pluck('creator', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchins = PunchingTrace::pluck('att_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $punchouts = PunchingTrace::pluck('att_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $overtime->load('employee', 'form', 'punchin', 'punchout');

        return view('admin.overtimes.edit', compact('employees', 'forms', 'overtime', 'punchins', 'punchouts'));
    }

    public function update(UpdateOvertimeRequest $request, Overtime $overtime)
    {
        $overtime->update($request->all());

        return redirect()->route('admin.overtimes.index');
    }

    public function show(Overtime $overtime)
    {
        abort_if(Gate::denies('overtime_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtime->load('employee', 'form', 'punchin', 'punchout');

        return view('admin.overtimes.show', compact('overtime'));
    }

    public function destroy(Overtime $overtime)
    {
        abort_if(Gate::denies('overtime_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtime->delete();

        return back();
    }

    public function massDestroy(MassDestroyOvertimeRequest $request)
    {
        $overtimes = Overtime::find(request('ids'));

        foreach ($overtimes as $overtime) {
            $overtime->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
