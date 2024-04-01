<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOvertimeOtherRequest;
use App\Http\Requests\StoreOvertimeOtherRequest;
use App\Http\Requests\UpdateOvertimeOtherRequest;
use App\Models\DeptEmployee;
use App\Models\OtFormOther;
use App\Models\OvertimeOther;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OvertimeOtherController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('overtime_other_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = OvertimeOther::with(['employee', 'form'])->select(sprintf('%s.*', (new OvertimeOther)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'overtime_other_show';
                $editGate      = 'overtime_other_edit';
                $deleteGate    = 'overtime_other_delete';
                $crudRoutePart = 'overtime-others';

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

            $table->rawColumns(['actions', 'placeholder', 'employee', 'form']);

            return $table->make(true);
        }

        return view('admin.overtimeOthers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('overtime_other_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = DeptEmployee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = OtFormOther::pluck('creator', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.overtimeOthers.create', compact('employees', 'forms'));
    }

    public function store(StoreOvertimeOtherRequest $request)
    {
        $overtimeOther = OvertimeOther::create($request->all());

        return redirect()->route('admin.overtime-others.index');
    }

    public function edit(OvertimeOther $overtimeOther)
    {
        abort_if(Gate::denies('overtime_other_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = DeptEmployee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = OtFormOther::pluck('creator', 'id')->prepend(trans('global.pleaseSelect'), '');

        $overtimeOther->load('employee', 'form');

        return view('admin.overtimeOthers.edit', compact('employees', 'forms', 'overtimeOther'));
    }

    public function update(UpdateOvertimeOtherRequest $request, OvertimeOther $overtimeOther)
    {
        $overtimeOther->update($request->all());

        return redirect()->route('admin.overtime-others.index');
    }

    public function show(OvertimeOther $overtimeOther)
    {
        abort_if(Gate::denies('overtime_other_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimeOther->load('employee', 'form');

        return view('admin.overtimeOthers.show', compact('overtimeOther'));
    }

    public function destroy(OvertimeOther $overtimeOther)
    {
        abort_if(Gate::denies('overtime_other_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimeOther->delete();

        return back();
    }

    public function massDestroy(MassDestroyOvertimeOtherRequest $request)
    {
        $overtimeOthers = OvertimeOther::find(request('ids'));

        foreach ($overtimeOthers as $overtimeOther) {
            $overtimeOther->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
