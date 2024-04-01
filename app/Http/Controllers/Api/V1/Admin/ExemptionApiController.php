<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExemptionRequest;
use App\Http\Requests\UpdateExemptionRequest;
use App\Http\Resources\Admin\ExemptionResource;
use App\Models\Exemption;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExemptionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('exemption_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExemptionResource(Exemption::with(['employee'])->get());
    }

    public function store(StoreExemptionRequest $request)
    {
        $exemption = Exemption::create($request->all());

        return (new ExemptionResource($exemption))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Exemption $exemption)
    {
        abort_if(Gate::denies('exemption_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExemptionResource($exemption->load(['employee']));
    }

    public function update(UpdateExemptionRequest $request, Exemption $exemption)
    {
        $exemption->update($request->all());

        return (new ExemptionResource($exemption))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Exemption $exemption)
    {
        abort_if(Gate::denies('exemption_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exemption->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
