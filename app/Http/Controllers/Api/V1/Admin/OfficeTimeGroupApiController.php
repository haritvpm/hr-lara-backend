<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeTimeGroupRequest;
use App\Http\Requests\UpdateOfficeTimeGroupRequest;
use App\Http\Resources\Admin\OfficeTimeGroupResource;
use App\Models\OfficeTimeGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeTimeGroupApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('office_time_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfficeTimeGroupResource(OfficeTimeGroup::all());
    }

    public function store(StoreOfficeTimeGroupRequest $request)
    {
        $officeTimeGroup = OfficeTimeGroup::create($request->all());

        return (new OfficeTimeGroupResource($officeTimeGroup))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OfficeTimeGroup $officeTimeGroup)
    {
        abort_if(Gate::denies('office_time_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfficeTimeGroupResource($officeTimeGroup);
    }

    public function update(UpdateOfficeTimeGroupRequest $request, OfficeTimeGroup $officeTimeGroup)
    {
        $officeTimeGroup->update($request->all());

        return (new OfficeTimeGroupResource($officeTimeGroup))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OfficeTimeGroup $officeTimeGroup)
    {
        abort_if(Gate::denies('office_time_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $officeTimeGroup->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
