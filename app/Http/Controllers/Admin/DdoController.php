<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDdoRequest;
use App\Http\Requests\StoreDdoRequest;
use App\Http\Requests\UpdateDdoRequest;
use App\Models\AdministrativeOffice;
use App\Models\Ddo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DdoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ddo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ddos = Ddo::with(['office'])->get();

        return view('admin.ddos.index', compact('ddos'));
    }

    public function create()
    {
        abort_if(Gate::denies('ddo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offices = AdministrativeOffice::pluck('office_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.ddos.create', compact('offices'));
    }

    public function store(StoreDdoRequest $request)
    {
        $ddo = Ddo::create($request->all());

        return redirect()->route('admin.ddos.index');
    }

    public function edit(Ddo $ddo)
    {
        abort_if(Gate::denies('ddo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offices = AdministrativeOffice::pluck('office_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ddo->load('office');

        return view('admin.ddos.edit', compact('ddo', 'offices'));
    }

    public function update(UpdateDdoRequest $request, Ddo $ddo)
    {
        $ddo->update($request->all());

        return redirect()->route('admin.ddos.index');
    }

    public function show(Ddo $ddo)
    {
        abort_if(Gate::denies('ddo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ddo->load('office');

        return view('admin.ddos.show', compact('ddo'));
    }

    public function destroy(Ddo $ddo)
    {
        abort_if(Gate::denies('ddo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ddo->delete();

        return back();
    }

    public function massDestroy(MassDestroyDdoRequest $request)
    {
        $ddos = Ddo::find(request('ids'));

        foreach ($ddos as $ddo) {
            $ddo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
