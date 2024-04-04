<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\PunchingTrace;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PunchingTraceController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('punching_trace_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PunchingTrace::with(['punching'])->select(sprintf('%s.*', (new PunchingTrace)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'punching_trace_show';
                $editGate      = 'punching_trace_edit';
                $deleteGate    = 'punching_trace_delete';
                $crudRoutePart = 'punching-traces';

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
            $table->editColumn('org_emp_code', function ($row) {
                return $row->org_emp_code ? $row->org_emp_code : '';
            });
            $table->editColumn('device', function ($row) {
                return $row->device ? $row->device : '';
            });
            $table->editColumn('attendance_type', function ($row) {
                return $row->attendance_type ? $row->attendance_type : '';
            });
            $table->editColumn('auth_status', function ($row) {
                return $row->auth_status ? $row->auth_status : '';
            });
            $table->editColumn('err_code', function ($row) {
                return $row->err_code ? $row->err_code : '';
            });

            $table->editColumn('att_time', function ($row) {
                return $row->att_time ? $row->att_time : '';
            });
            $table->editColumn('day_offset', function ($row) {
                return $row->day_offset ? $row->day_offset : '';
            });
            $table->addColumn('punching_date', function ($row) {
                return $row->punching ? $row->punching->date : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'punching']);

            return $table->make(true);
        }

        return view('admin.punchingTraces.index');
    }
}
