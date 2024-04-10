<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OvertimeSitting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OvertimeSittingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('overtime_sitting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = OvertimeSitting::with(['overtime'])->select(sprintf('%s.*', (new OvertimeSitting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'overtime_sitting_show';
                $editGate      = 'overtime_sitting_edit';
                $deleteGate    = 'overtime_sitting_delete';
                $crudRoutePart = 'overtime-sittings';

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

            $table->editColumn('checked', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->checked ? 'checked' : null) . '>';
            });
            $table->addColumn('overtime_slots', function ($row) {
                return $row->overtime ? $row->overtime->slots : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'checked', 'overtime']);

            return $table->make(true);
        }

        return view('admin.overtimeSittings.index');
    }
}
