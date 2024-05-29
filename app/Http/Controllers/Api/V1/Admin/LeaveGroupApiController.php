<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeaveGroupRequest;
use App\Http\Requests\UpdateLeaveGroupRequest;
use App\Http\Resources\Admin\LeaveGroupResource;
use App\Models\LeaveGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeaveGroupApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leave_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeaveGroupResource(LeaveGroup::all());
    }

    public function store(StoreLeaveGroupRequest $request)
    {
        $leaveGroup = LeaveGroup::create($request->all());

        return (new LeaveGroupResource($leaveGroup))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LeaveGroup $leaveGroup)
    {
        abort_if(Gate::denies('leave_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeaveGroupResource($leaveGroup);
    }

    public function update(UpdateLeaveGroupRequest $request, LeaveGroup $leaveGroup)
    {
        $leaveGroup->update($request->all());

        return (new LeaveGroupResource($leaveGroup))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LeaveGroup $leaveGroup)
    {
        abort_if(Gate::denies('leave_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveGroup->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
