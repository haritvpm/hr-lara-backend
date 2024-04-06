<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeLocationRequest;
use App\Http\Requests\UpdateOfficeLocationRequest;
use App\Http\Resources\Admin\OfficeLocationResource;
use App\Models\OfficeLocation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeLocationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('office_location_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfficeLocationResource(OfficeLocation::with(['administrative_office'])->get());
    }

    public function store(StoreOfficeLocationRequest $request)
    {
        $officeLocation = OfficeLocation::create($request->all());

        return (new OfficeLocationResource($officeLocation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OfficeLocation $officeLocation)
    {
        abort_if(Gate::denies('office_location_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfficeLocationResource($officeLocation->load(['administrative_office']));
    }

    public function update(UpdateOfficeLocationRequest $request, OfficeLocation $officeLocation)
    {
        $officeLocation->update($request->all());

        return (new OfficeLocationResource($officeLocation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
