<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreOfficeLocationRequest;
use App\Http\Requests\UpdateOfficeLocationRequest;
use App\Models\OfficeLocation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeLocationController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('office_location_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $officeLocations = OfficeLocation::all();

        return view('admin.officeLocations.index', compact('officeLocations'));
    }

    public function create()
    {
        abort_if(Gate::denies('office_location_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeLocations.create');
    }

    public function store(StoreOfficeLocationRequest $request)
    {
        $officeLocation = OfficeLocation::create($request->all());

        return redirect()->route('admin.office-locations.index');
    }

    public function edit(OfficeLocation $officeLocation)
    {
        abort_if(Gate::denies('office_location_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeLocations.edit', compact('officeLocation'));
    }

    public function update(UpdateOfficeLocationRequest $request, OfficeLocation $officeLocation)
    {
        $officeLocation->update($request->all());

        return redirect()->route('admin.office-locations.index');
    }

    public function show(OfficeLocation $officeLocation)
    {
        abort_if(Gate::denies('office_location_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeLocations.show', compact('officeLocation'));
    }
}
