<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOvertimeOtherRequest;
use App\Http\Requests\UpdateOvertimeOtherRequest;
use App\Http\Resources\Admin\OvertimeOtherResource;
use App\Models\OvertimeOther;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OvertimeOtherApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('overtime_other_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OvertimeOtherResource(OvertimeOther::with(['employee', 'form'])->get());
    }

    public function store(StoreOvertimeOtherRequest $request)
    {
        $overtimeOther = OvertimeOther::create($request->all());

        return (new OvertimeOtherResource($overtimeOther))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OvertimeOther $overtimeOther)
    {
        abort_if(Gate::denies('overtime_other_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OvertimeOtherResource($overtimeOther->load(['employee', 'form']));
    }

    public function update(UpdateOvertimeOtherRequest $request, OvertimeOther $overtimeOther)
    {
        $overtimeOther->update($request->all());

        return (new OvertimeOtherResource($overtimeOther))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OvertimeOther $overtimeOther)
    {
        abort_if(Gate::denies('overtime_other_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $overtimeOther->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
