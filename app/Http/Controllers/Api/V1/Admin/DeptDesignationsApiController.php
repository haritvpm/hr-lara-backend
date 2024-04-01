<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeptDesignationRequest;
use App\Http\Requests\UpdateDeptDesignationRequest;
use App\Http\Resources\Admin\DeptDesignationResource;
use App\Models\DeptDesignation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeptDesignationsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dept_designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeptDesignationResource(DeptDesignation::with(['user'])->get());
    }

    public function store(StoreDeptDesignationRequest $request)
    {
        $deptDesignation = DeptDesignation::create($request->all());

        return (new DeptDesignationResource($deptDesignation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DeptDesignation $deptDesignation)
    {
        abort_if(Gate::denies('dept_designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeptDesignationResource($deptDesignation->load(['user']));
    }

    public function update(UpdateDeptDesignationRequest $request, DeptDesignation $deptDesignation)
    {
        $deptDesignation->update($request->all());

        return (new DeptDesignationResource($deptDesignation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeptDesignation $deptDesignation)
    {
        abort_if(Gate::denies('dept_designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deptDesignation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
