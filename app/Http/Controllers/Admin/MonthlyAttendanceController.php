<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMonthlyAttendanceRequest;
use App\Http\Requests\StoreMonthlyAttendanceRequest;
use App\Http\Requests\UpdateMonthlyAttendanceRequest;
use App\Models\MonthlyAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MonthlyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('monthly_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MonthlyAttendance::with(['employee'])->select(sprintf('%s.*', (new MonthlyAttendance)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'monthly_attendance_show';
                $editGate      = 'monthly_attendance_edit';
                $deleteGate    = 'monthly_attendance_delete';
                $crudRoutePart = 'monthly-attendances';

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
            $table->addColumn('employee_name', function ($row) {
                return $row->employee ? $row->employee->name : '';
            });

            $table->editColumn('employee.aadhaarid', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->aadhaarid) : '';
            });

            $table->editColumn('compoff_granted', function ($row) {
                return $row->compoff_granted ? $row->compoff_granted : '';
            });
            $table->editColumn('total_grace_sec', function ($row) {
                return $row->total_grace_sec ? $row->total_grace_sec : '';
            });
            $table->editColumn('total_extra_sec', function ($row) {
                return $row->total_extra_sec ? $row->total_extra_sec : '';
            });
            $table->editColumn('total_grace_str', function ($row) {
                return $row->total_grace_str ? $row->total_grace_str : '';
            });
            $table->editColumn('total_extra_str', function ($row) {
                return $row->total_extra_str ? $row->total_extra_str : '';
            });
            $table->editColumn('grace_exceeded_sec', function ($row) {
                return $row->grace_exceeded_sec ? $row->grace_exceeded_sec : '';
            });

            $table->editColumn('compen_marked', function ($row) {
                return $row->compen_marked ? $row->compen_marked : '';
            });
            $table->editColumn('compen_submitted', function ($row) {
                return $row->compen_submitted ? $row->compen_submitted : '';
            });
            $table->editColumn('other_leaves_marked', function ($row) {
                return $row->other_leaves_marked ? $row->other_leaves_marked : '';
            });
            $table->editColumn('other_leaves_submitted', function ($row) {
                return $row->other_leaves_submitted ? $row->other_leaves_submitted : '';
            });
            $table->editColumn('cl_marked', function ($row) {
                return $row->cl_marked ? $row->cl_marked : '';
            });
            $table->editColumn('cl_submitted', function ($row) {
                return $row->cl_submitted ? $row->cl_submitted : '';
            });
            $table->editColumn('grace_minutes', function ($row) {
                return $row->grace_minutes ? $row->grace_minutes : '';
            });
            $table->editColumn('single_punchings', function ($row) {
                return $row->single_punchings ? $row->single_punchings : '';
            });
            $table->editColumn('single_punchings_regularised', function ($row) {
                return $row->single_punchings_regularised ? $row->single_punchings_regularised : '';
            });
            $table->editColumn('unauthorised_count', function ($row) {
                return $row->unauthorised_count ? $row->unauthorised_count : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.monthlyAttendances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('monthly_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyAttendances.create');
    }

    public function store(StoreMonthlyAttendanceRequest $request)
    {
        $monthlyAttendance = MonthlyAttendance::create($request->all());

        return redirect()->route('admin.monthly-attendances.index');
    }

    public function edit(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendance->load('employee');

        return view('admin.monthlyAttendances.edit', compact('monthlyAttendance'));
    }

    public function update(UpdateMonthlyAttendanceRequest $request, MonthlyAttendance $monthlyAttendance)
    {
        $monthlyAttendance->update($request->all());

        return redirect()->route('admin.monthly-attendances.index');
    }

    public function show(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendance->load('employee');

        return view('admin.monthlyAttendances.show', compact('monthlyAttendance'));
    }

    public function destroy(MonthlyAttendance $monthlyAttendance)
    {
        abort_if(Gate::denies('monthly_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyMonthlyAttendanceRequest $request)
    {
        $monthlyAttendances = MonthlyAttendance::find(request('ids'));

        foreach ($monthlyAttendances as $monthlyAttendance) {
            $monthlyAttendance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
