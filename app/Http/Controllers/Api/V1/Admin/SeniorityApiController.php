<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeniorityRequest;
use App\Http\Requests\UpdateSeniorityRequest;
use App\Http\Resources\Admin\SeniorityResource;
use App\Models\Seniority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeniorityApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seniority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeniorityResource(Seniority::with(['employee'])->get());
    }

    public function store(StoreSeniorityRequest $request)
    {
        $seniority = Seniority::create($request->all());

        return (new SeniorityResource($seniority))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Seniority $seniority)
    {
        abort_if(Gate::denies('seniority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeniorityResource($seniority->load(['employee']));
    }

    public function update(UpdateSeniorityRequest $request, Seniority $seniority)
    {
        $seniority->update($request->all());

        return (new SeniorityResource($seniority))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Seniority $seniority)
    {
        abort_if(Gate::denies('seniority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seniority->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
