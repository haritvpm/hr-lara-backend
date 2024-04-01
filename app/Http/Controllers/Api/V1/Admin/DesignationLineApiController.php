<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationLineRequest;
use App\Http\Requests\UpdateDesignationLineRequest;
use App\Http\Resources\Admin\DesignationLineResource;
use App\Models\DesignationLine;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationLineApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('designation_line_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DesignationLineResource(DesignationLine::all());
    }

    public function store(StoreDesignationLineRequest $request)
    {
        $designationLine = DesignationLine::create($request->all());

        return (new DesignationLineResource($designationLine))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DesignationLine $designationLine)
    {
        abort_if(Gate::denies('designation_line_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DesignationLineResource($designationLine);
    }

    public function update(UpdateDesignationLineRequest $request, DesignationLine $designationLine)
    {
        $designationLine->update($request->all());

        return (new DesignationLineResource($designationLine))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DesignationLine $designationLine)
    {
        abort_if(Gate::denies('designation_line_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designationLine->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
