<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcquittanceRequest;
use App\Http\Requests\UpdateAcquittanceRequest;
use App\Http\Resources\Admin\AcquittanceResource;
use App\Models\Acquittance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcquittanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('acquittance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AcquittanceResource(Acquittance::with(['office', 'ddo'])->get());
    }

    public function store(StoreAcquittanceRequest $request)
    {
        $acquittance = Acquittance::create($request->all());

        return (new AcquittanceResource($acquittance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Acquittance $acquittance)
    {
        abort_if(Gate::denies('acquittance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AcquittanceResource($acquittance->load(['office', 'ddo']));
    }

    public function update(UpdateAcquittanceRequest $request, Acquittance $acquittance)
    {
        $acquittance->update($request->all());

        return (new AcquittanceResource($acquittance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Acquittance $acquittance)
    {
        abort_if(Gate::denies('acquittance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acquittance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
