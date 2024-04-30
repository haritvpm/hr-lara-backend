<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyYearlyAttendanceRequest;
use App\Http\Requests\StoreYearlyAttendanceRequest;
use App\Http\Requests\UpdateYearlyAttendanceRequest;
use App\Models\YearlyAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class YearlyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('yearly_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = YearlyAttendance::with(['employee'])->select(sprintf('%s.*', (new YearlyAttendance)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'yearly_attendance_show';
                $editGate      = 'yearly_attendance_edit';
                $deleteGate    = 'yearly_attendance_delete';
                $crudRoutePart = 'yearly-attendances';

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

            $table->editColumn('cl_marked', function ($row) {
                return $row->cl_marked ? $row->cl_marked : '';
            });
            $table->editColumn('cl_submitted', function ($row) {
                return $row->cl_submitted ? $row->cl_submitted : '';
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

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.yearlyAttendances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('yearly_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.yearlyAttendances.create');
    }

    public function store(StoreYearlyAttendanceRequest $request)
    {
        $yearlyAttendance = YearlyAttendance::create($request->all());

        return redirect()->route('admin.yearly-attendances.index');
    }

    public function edit(YearlyAttendance $yearlyAttendance)
    {
        abort_if(Gate::denies('yearly_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearlyAttendance->load('employee');

        return view('admin.yearlyAttendances.edit', compact('yearlyAttendance'));
    }

    public function update(UpdateYearlyAttendanceRequest $request, YearlyAttendance $yearlyAttendance)
    {
        $yearlyAttendance->update($request->all());

        return redirect()->route('admin.yearly-attendances.index');
    }

    public function show(YearlyAttendance $yearlyAttendance)
    {
        abort_if(Gate::denies('yearly_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearlyAttendance->load('employee');

        return view('admin.yearlyAttendances.show', compact('yearlyAttendance'));
    }

    public function destroy(YearlyAttendance $yearlyAttendance)
    {
        abort_if(Gate::denies('yearly_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearlyAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyYearlyAttendanceRequest $request)
    {
        $yearlyAttendances = YearlyAttendance::find(request('ids'));

        foreach ($yearlyAttendances as $yearlyAttendance) {
            $yearlyAttendance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
