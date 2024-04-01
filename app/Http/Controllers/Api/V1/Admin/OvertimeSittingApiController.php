<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOvertimeSittingRequest;
use App\Http\Requests\UpdateOvertimeSittingRequest;
use App\Http\Resources\Admin\OvertimeSittingResource;
use App\Models\OvertimeSitting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OvertimeSittingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('overtime_sitting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OvertimeSittingResource(OvertimeSitting::with(['overtime'])->get());
    }

    public function store(StoreOvertimeSittingRequest $request)
    {
        $overtimeSitting = OvertimeSitting::create($request->all());

        return (new OvertimeSittingResource($overtimeSitting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OvertimeSitting $overtimeSitting)
    {
        abort_if(Gate::denies('overtime_sitting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OvertimeSittingResource($overtimeSitting->load(['overtime']));
    }

    public function update(UpdateOvertimeSittingRequest $request, OvertimeSitting $overtimeSitting)
    {
        $overtimeSitting->update($request->all());

        return (new OvertimeSittingResource($overtimeSitting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OvertimeSitting $overtimeSitting)
    {
        abort_if(Gate::denies('overtime_sitting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimeSitting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
