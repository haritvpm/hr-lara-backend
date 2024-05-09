<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeafRequest;
use App\Http\Requests\UpdateLeafRequest;
use App\Models\Employee;
use App\Models\Leaf;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('leaf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Leaf::with(['employee'])->select(sprintf('%s.*', (new Leaf)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'leaf_show';
                $editGate      = 'leaf_edit';
                $deleteGate    = 'leaf_delete';
                $crudRoutePart = 'leaves';

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
            // $table->addColumn('employee_name', function ($row) {
            //     return $row->employee ? $row->employee->name : '';
            // });

            $table->editColumn('leave_type', function ($row) {
                return $row->leave_type ? $row->leave_type : '';
                //return $row->leave_type ? Leaf::LEAVE_TYPE_SELECT[$row->leave_type] : '';
            });

            $table->editColumn('reason', function ($row) {
                return $row->reason ? $row->reason : '';
            });
            $table->editColumn('active_status', function ($row) {
                return $row->active_status ? $row->active_status : '';
            });
            $table->editColumn('leave_cat', function ($row) {
                return $row->leave_cat ? $row->leave_cat : '';
                //return $row->leave_cat ? Leaf::LEAVE_CAT_SELECT[$row->leave_cat] : '';
            });
            $table->editColumn('time_period', function ($row) {
                return $row->time_period ? $row->time_period: '';
                //return $row->time_period ? Leaf::TIME_PERIOD_SELECT[$row->time_period] : '';
            });

            $table->editColumn('created_by_aadhaarid', function ($row) {
                return $row->created_by_aadhaarid ? $row->created_by_aadhaarid : '';
            });
            $table->editColumn('processed', function ($row) {
                return $row->processed ? $row->processed : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.leaves.index');
    }

    public function edit(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaf->load('employee');

        return view('admin.leaves.edit', compact('employees', 'leaf'));
    }

    public function update(UpdateLeafRequest $request, Leaf $leaf)
    {
        $leaf->update($request->all());

        return redirect()->route('admin.leaves.index');
    }

    public function show(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaf->load('employee');

        return view('admin.leaves.show', compact('leaf'));
    }

    public function destroy(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaf->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeafRequest $request)
    {
        $leaves = Leaf::find(request('ids'));

        foreach ($leaves as $leaf) {
            $leaf->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
