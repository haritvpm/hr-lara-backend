<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOvertimeSittingRequest;
use App\Http\Requests\StoreOvertimeSittingRequest;
use App\Http\Requests\UpdateOvertimeSittingRequest;
use App\Models\Overtime;
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

    public function create()
    {
        abort_if(Gate::denies('overtime_sitting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimes = Overtime::pluck('slots', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.overtimeSittings.create', compact('overtimes'));
    }

    public function store(StoreOvertimeSittingRequest $request)
    {
        $overtimeSitting = OvertimeSitting::create($request->all());

        return redirect()->route('admin.overtime-sittings.index');
    }

    public function edit(OvertimeSitting $overtimeSitting)
    {
        abort_if(Gate::denies('overtime_sitting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimes = Overtime::pluck('slots', 'id')->prepend(trans('global.pleaseSelect'), '');

        $overtimeSitting->load('overtime');

        return view('admin.overtimeSittings.edit', compact('overtimeSitting', 'overtimes'));
    }

    public function update(UpdateOvertimeSittingRequest $request, OvertimeSitting $overtimeSitting)
    {
        $overtimeSitting->update($request->all());

        return redirect()->route('admin.overtime-sittings.index');
    }

    public function show(OvertimeSitting $overtimeSitting)
    {
        abort_if(Gate::denies('overtime_sitting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimeSitting->load('overtime');

        return view('admin.overtimeSittings.show', compact('overtimeSitting'));
    }

    public function destroy(OvertimeSitting $overtimeSitting)
    {
        abort_if(Gate::denies('overtime_sitting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimeSitting->delete();

        return back();
    }

    public function massDestroy(MassDestroyOvertimeSittingRequest $request)
    {
        $overtimeSittings = OvertimeSitting::find(request('ids'));

        foreach ($overtimeSittings as $overtimeSitting) {
            $overtimeSitting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
