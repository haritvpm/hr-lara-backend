<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGraceTimeRequest;
use App\Http\Requests\UpdateGraceTimeRequest;
use App\Http\Resources\Admin\GraceTimeResource;
use App\Models\GraceTime;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GraceTimeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('grace_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GraceTimeResource(GraceTime::all());
    }

    public function store(StoreGraceTimeRequest $request)
    {
        $graceTime = GraceTime::create($request->all());

        return (new GraceTimeResource($graceTime))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateGraceTimeRequest $request, GraceTime $graceTime)
    {
        $graceTime->update($request->all());

        return (new GraceTimeResource($graceTime))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(GraceTime $graceTime)
    {
        abort_if(Gate::denies('grace_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $graceTime->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
