<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySuccessPunchingRequest;
use App\Http\Requests\StoreSuccessPunchingRequest;
use App\Http\Requests\UpdateSuccessPunchingRequest;
use App\Models\SuccessPunching;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SuccessPunchingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('success_punching_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SuccessPunching::query()->select(sprintf('%s.*', (new SuccessPunching)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'success_punching_show';
                $editGate      = 'success_punching_edit';
                $deleteGate    = 'success_punching_delete';
                $crudRoutePart = 'success-punchings';

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

            $table->editColumn('punch_in', function ($row) {
                return $row->punch_in ? $row->punch_in : '';
            });
            $table->editColumn('punch_out', function ($row) {
                return $row->punch_out ? $row->punch_out : '';
            });
            $table->editColumn('pen', function ($row) {
                return $row->pen ? $row->pen : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('in_device', function ($row) {
                return $row->in_device ? $row->in_device : '';
            });

            $table->editColumn('out_device', function ($row) {
                return $row->out_device ? $row->out_device : '';
            });

            $table->editColumn('at_type', function ($row) {
                return $row->at_type ? $row->at_type : '';
            });
            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });
            $table->editColumn('aadhaarid', function ($row) {
                return $row->aadhaarid ? $row->aadhaarid : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.successPunchings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('success_punching_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.successPunchings.create');
    }

    public function store(StoreSuccessPunchingRequest $request)
    {
        $successPunching = SuccessPunching::create($request->all());

        return redirect()->route('admin.success-punchings.index');
    }

    public function edit(SuccessPunching $successPunching)
    {
        abort_if(Gate::denies('success_punching_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.successPunchings.edit', compact('successPunching'));
    }

    public function update(UpdateSuccessPunchingRequest $request, SuccessPunching $successPunching)
    {
        $successPunching->update($request->all());

        return redirect()->route('admin.success-punchings.index');
    }

    public function show(SuccessPunching $successPunching)
    {
        abort_if(Gate::denies('success_punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.successPunchings.show', compact('successPunching'));
    }

    public function destroy(SuccessPunching $successPunching)
    {
        abort_if(Gate::denies('success_punching_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $successPunching->delete();

        return back();
    }

    public function massDestroy(MassDestroySuccessPunchingRequest $request)
    {
        $successPunchings = SuccessPunching::find(request('ids'));

        foreach ($successPunchings as $successPunching) {
            $successPunching->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
