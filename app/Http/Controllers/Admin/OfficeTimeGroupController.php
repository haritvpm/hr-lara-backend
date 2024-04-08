<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOfficeTimeGroupRequest;
use App\Http\Requests\StoreOfficeTimeGroupRequest;
use App\Http\Requests\UpdateOfficeTimeGroupRequest;
use App\Models\OfficeTimeGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeTimeGroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('office_time_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $officeTimeGroups = OfficeTimeGroup::all();

        return view('admin.officeTimeGroups.index', compact('officeTimeGroups'));
    }

    public function create()
    {
        abort_if(Gate::denies('office_time_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeTimeGroups.create');
    }

    public function store(StoreOfficeTimeGroupRequest $request)
    {
        $officeTimeGroup = OfficeTimeGroup::create($request->all());

        return redirect()->route('admin.office-time-groups.index');
    }

    public function edit(OfficeTimeGroup $officeTimeGroup)
    {
        abort_if(Gate::denies('office_time_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeTimeGroups.edit', compact('officeTimeGroup'));
    }

    public function update(UpdateOfficeTimeGroupRequest $request, OfficeTimeGroup $officeTimeGroup)
    {
        $officeTimeGroup->update($request->all());

        return redirect()->route('admin.office-time-groups.index');
    }

    public function show(OfficeTimeGroup $officeTimeGroup)
    {
        abort_if(Gate::denies('office_time_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.officeTimeGroups.show', compact('officeTimeGroup'));
    }

    public function destroy(OfficeTimeGroup $officeTimeGroup)
    {
        abort_if(Gate::denies('office_time_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $officeTimeGroup->delete();

        return back();
    }

    public function massDestroy(MassDestroyOfficeTimeGroupRequest $request)
    {
        $officeTimeGroups = OfficeTimeGroup::find(request('ids'));

        foreach ($officeTimeGroups as $officeTimeGroup) {
            $officeTimeGroup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
