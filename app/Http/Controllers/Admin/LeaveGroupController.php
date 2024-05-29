<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeaveGroupRequest;
use App\Http\Requests\StoreLeaveGroupRequest;
use App\Http\Requests\UpdateLeaveGroupRequest;
use App\Models\LeaveGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeaveGroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leave_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveGroups = LeaveGroup::all();

        return view('admin.leaveGroups.index', compact('leaveGroups'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveGroups.create');
    }

    public function store(StoreLeaveGroupRequest $request)
    {
        $leaveGroup = LeaveGroup::create($request->all());

        return redirect()->route('admin.leave-groups.index');
    }

    public function edit(LeaveGroup $leaveGroup)
    {
        abort_if(Gate::denies('leave_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveGroups.edit', compact('leaveGroup'));
    }

    public function update(UpdateLeaveGroupRequest $request, LeaveGroup $leaveGroup)
    {
        $leaveGroup->update($request->all());

        return redirect()->route('admin.leave-groups.index');
    }

    public function show(LeaveGroup $leaveGroup)
    {
        abort_if(Gate::denies('leave_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveGroups.show', compact('leaveGroup'));
    }

    public function destroy(LeaveGroup $leaveGroup)
    {
        abort_if(Gate::denies('leave_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeaveGroupRequest $request)
    {
        $leaveGroups = LeaveGroup::find(request('ids'));

        foreach ($leaveGroups as $leaveGroup) {
            $leaveGroup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
