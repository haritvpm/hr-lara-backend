<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdministrativeOfficeRequest;
use App\Http\Requests\UpdateAdministrativeOfficeRequest;
use App\Http\Resources\Admin\AdministrativeOfficeResource;
use App\Models\AdministrativeOffice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministrativeOfficeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('administrative_office_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdministrativeOfficeResource(AdministrativeOffice::all());
    }

    public function store(StoreAdministrativeOfficeRequest $request)
    {
        $administrativeOffice = AdministrativeOffice::create($request->all());

        return (new AdministrativeOfficeResource($administrativeOffice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdministrativeOffice $administrativeOffice)
    {
        abort_if(Gate::denies('administrative_office_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdministrativeOfficeResource($administrativeOffice);
    }

    public function update(UpdateAdministrativeOfficeRequest $request, AdministrativeOffice $administrativeOffice)
    {
        $administrativeOffice->update($request->all());

        return (new AdministrativeOfficeResource($administrativeOffice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdministrativeOffice $administrativeOffice)
    {
        abort_if(Gate::denies('administrative_office_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $administrativeOffice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
