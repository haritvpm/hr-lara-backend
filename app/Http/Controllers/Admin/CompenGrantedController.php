<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCompenGrantedRequest;
use App\Http\Requests\StoreCompenGrantedRequest;
use App\Http\Requests\UpdateCompenGrantedRequest;
use App\Models\CompenGranted;
use App\Models\Employee;
use App\Models\Leaf;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CompenGrantedController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('compen_granted_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CompenGranted::with(['employee', 'leave'])->select(sprintf('%s.*', (new CompenGranted)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'compen_granted_show';
                $editGate      = 'compen_granted_edit';
                $deleteGate    = 'compen_granted_delete';
                $crudRoutePart = 'compen-granteds';

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
            $table->editColumn('aadhaarid', function ($row) {
                return $row->aadhaarid ? $row->aadhaarid : '';
            });

            $table->editColumn('is_for_extra_hours', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_for_extra_hours ? 'checked' : null) . '>';
            });
            $table->addColumn('employee_name', function ($row) {
                return $row->employee ? $row->employee->name : '';
            });

            $table->editColumn('employee.pen', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->pen) : '';
            });
            $table->addColumn('leave_start_date', function ($row) {
                return $row->leave ? $row->leave->start_date : '';
            });

            $table->editColumn('leave.start_date', function ($row) {
                return $row->leave ? (is_string($row->leave) ? $row->leave : $row->leave->start_date) : '';
            });
            $table->editColumn('leave.end_date', function ($row) {
                return $row->leave ? (is_string($row->leave) ? $row->leave : $row->leave->end_date) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_for_extra_hours', 'employee', 'leave']);

            return $table->make(true);
        }

        return view('admin.compenGranteds.index');
    }

    public function create()
    {
        abort_if(Gate::denies('compen_granted_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaves = Leaf::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.compenGranteds.create', compact('employees', 'leaves'));
    }

    public function store(StoreCompenGrantedRequest $request)
    {
        $compenGranted = CompenGranted::create($request->all());

        return redirect()->route('admin.compen-granteds.index');
    }

    public function edit(CompenGranted $compenGranted)
    {
        abort_if(Gate::denies('compen_granted_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaves = Leaf::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $compenGranted->load('employee', 'leave');

        return view('admin.compenGranteds.edit', compact('compenGranted', 'employees', 'leaves'));
    }

    public function update(UpdateCompenGrantedRequest $request, CompenGranted $compenGranted)
    {
        $compenGranted->update($request->all());

        return redirect()->route('admin.compen-granteds.index');
    }

    public function destroy(CompenGranted $compenGranted)
    {
        abort_if(Gate::denies('compen_granted_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $compenGranted->delete();

        return back();
    }

    public function massDestroy(MassDestroyCompenGrantedRequest $request)
    {
        $compenGranteds = CompenGranted::find(request('ids'));

        foreach ($compenGranteds as $compenGranted) {
            $compenGranted->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
