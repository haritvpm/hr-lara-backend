<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeTimeRequest;
use App\Http\Requests\UpdateOfficeTimeRequest;
use App\Http\Resources\Admin\OfficeTimeResource;
use App\Models\OfficeTime;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeTimesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfficeTimeResource(OfficeTime::with(['time_group'])->get());
    }

    public function store(StoreOfficeTimeRequest $request)
    {
        $officeTime = OfficeTime::create($request->all());

        return (new OfficeTimeResource($officeTime))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OfficeTime $officeTime)
    {
        abort_if(Gate::denies('office_time_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfficeTimeResource($officeTime->load(['time_group']));
    }

    public function update(UpdateOfficeTimeRequest $request, OfficeTime $officeTime)
    {
        $officeTime->update($request->all());

        return (new OfficeTimeResource($officeTime))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OfficeTime $officeTime)
    {
        abort_if(Gate::denies('office_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $officeTime->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
