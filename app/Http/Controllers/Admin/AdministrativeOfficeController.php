<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdministrativeOfficeRequest;
use App\Http\Requests\StoreAdministrativeOfficeRequest;
use App\Http\Requests\UpdateAdministrativeOfficeRequest;
use App\Models\AdministrativeOffice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministrativeOfficeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('administrative_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $administrativeOffices = AdministrativeOffice::all();

        return view('admin.administrativeOffices.index', compact('administrativeOffices'));
    }

    public function create()
    {
        abort_if(Gate::denies('administrative_office_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.administrativeOffices.create');
    }

    public function store(StoreAdministrativeOfficeRequest $request)
    {
        $administrativeOffice = AdministrativeOffice::create($request->all());

        return redirect()->route('admin.administrative-offices.index');
    }

    public function edit(AdministrativeOffice $administrativeOffice)
    {
        abort_if(Gate::denies('administrative_office_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.administrativeOffices.edit', compact('administrativeOffice'));
    }

    public function update(UpdateAdministrativeOfficeRequest $request, AdministrativeOffice $administrativeOffice)
    {
        $administrativeOffice->update($request->all());

        return redirect()->route('admin.administrative-offices.index');
    }

    public function show(AdministrativeOffice $administrativeOffice)
    {
        abort_if(Gate::denies('administrative_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.administrativeOffices.show', compact('administrativeOffice'));
    }

    public function destroy(AdministrativeOffice $administrativeOffice)
    {
        abort_if(Gate::denies('administrative_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $administrativeOffice->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdministrativeOfficeRequest $request)
    {
        $administrativeOffices = AdministrativeOffice::find(request('ids'));

        foreach ($administrativeOffices as $administrativeOffice) {
            $administrativeOffice->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
