<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompenGrantedRequest;
use App\Http\Requests\UpdateCompenGrantedRequest;
use App\Http\Resources\Admin\CompenGrantedResource;
use App\Models\CompenGranted;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompenGrantedApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('compen_granted_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompenGrantedResource(CompenGranted::with(['employee', 'leave'])->get());
    }

    public function store(StoreCompenGrantedRequest $request)
    {
        $compenGranted = CompenGranted::create($request->all());

        return (new CompenGrantedResource($compenGranted))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateCompenGrantedRequest $request, CompenGranted $compenGranted)
    {
        $compenGranted->update($request->all());

        return (new CompenGrantedResource($compenGranted))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CompenGranted $compenGranted)
    {
        abort_if(Gate::denies('compen_granted_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $compenGranted->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
