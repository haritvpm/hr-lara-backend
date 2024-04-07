<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAcquittanceRequest;
use App\Http\Requests\StoreAcquittanceRequest;
use App\Http\Requests\UpdateAcquittanceRequest;
use App\Models\Acquittance;
use App\Models\AdministrativeOffice;
use App\Models\Ddo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcquittanceController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('acquittance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acquittances = Acquittance::with(['office', 'ddo'])->get();

        return view('admin.acquittances.index', compact('acquittances'));
    }

    public function create()
    {
        abort_if(Gate::denies('acquittance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offices = AdministrativeOffice::pluck('office_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ddos = Ddo::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.acquittances.create', compact('ddos', 'offices'));
    }

    public function store(StoreAcquittanceRequest $request)
    {
        $acquittance = Acquittance::create($request->all());

        return redirect()->route('admin.acquittances.index');
    }

    public function edit(Acquittance $acquittance)
    {
        abort_if(Gate::denies('acquittance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offices = AdministrativeOffice::pluck('office_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ddos = Ddo::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $acquittance->load('office', 'ddo');

        return view('admin.acquittances.edit', compact('acquittance', 'ddos', 'offices'));
    }

    public function update(UpdateAcquittanceRequest $request, Acquittance $acquittance)
    {
        $acquittance->update($request->all());

        return redirect()->route('admin.acquittances.index');
    }

    public function show(Acquittance $acquittance)
    {
        abort_if(Gate::denies('acquittance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acquittance->load('office', 'ddo');

        return view('admin.acquittances.show', compact('acquittance'));
    }

    public function destroy(Acquittance $acquittance)
    {
        abort_if(Gate::denies('acquittance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acquittance->delete();

        return back();
    }

    public function massDestroy(MassDestroyAcquittanceRequest $request)
    {
        $acquittances = Acquittance::find(request('ids'));

        foreach ($acquittances as $acquittance) {
            $acquittance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
