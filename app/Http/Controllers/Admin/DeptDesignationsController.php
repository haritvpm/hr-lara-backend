<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDeptDesignationRequest;
use App\Http\Requests\StoreDeptDesignationRequest;
use App\Http\Requests\UpdateDeptDesignationRequest;
use App\Models\DeptDesignation;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeptDesignationsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('dept_designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptDesignations = DeptDesignation::with(['user'])->get();

        return view('admin.deptDesignations.index', compact('deptDesignations'));
    }

    public function create()
    {
        abort_if(Gate::denies('dept_designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.deptDesignations.create', compact('users'));
    }

    public function store(StoreDeptDesignationRequest $request)
    {
        $deptDesignation = DeptDesignation::create($request->all());

        return redirect()->route('admin.dept-designations.index');
    }

    public function edit(DeptDesignation $deptDesignation)
    {
        abort_if(Gate::denies('dept_designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deptDesignation->load('user');

        return view('admin.deptDesignations.edit', compact('deptDesignation', 'users'));
    }

    public function update(UpdateDeptDesignationRequest $request, DeptDesignation $deptDesignation)
    {
        $deptDesignation->update($request->all());

        return redirect()->route('admin.dept-designations.index');
    }

    public function show(DeptDesignation $deptDesignation)
    {
        abort_if(Gate::denies('dept_designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptDesignation->load('user');

        return view('admin.deptDesignations.show', compact('deptDesignation'));
    }

    public function destroy(DeptDesignation $deptDesignation)
    {
        abort_if(Gate::denies('dept_designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptDesignation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeptDesignationRequest $request)
    {
        $deptDesignations = DeptDesignation::find(request('ids'));

        foreach ($deptDesignations as $deptDesignation) {
            $deptDesignation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
