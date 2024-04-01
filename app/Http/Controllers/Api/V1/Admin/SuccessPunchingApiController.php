<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuccessPunchingRequest;
use App\Http\Requests\UpdateSuccessPunchingRequest;
use App\Http\Resources\Admin\SuccessPunchingResource;
use App\Models\SuccessPunching;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuccessPunchingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('success_punching_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SuccessPunchingResource(SuccessPunching::all());
    }

    public function store(StoreSuccessPunchingRequest $request)
    {
        $successPunching = SuccessPunching::create($request->all());

        return (new SuccessPunchingResource($successPunching))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SuccessPunching $successPunching)
    {
        abort_if(Gate::denies('success_punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SuccessPunchingResource($successPunching);
    }

    public function update(UpdateSuccessPunchingRequest $request, SuccessPunching $successPunching)
    {
        $successPunching->update($request->all());

        return (new SuccessPunchingResource($successPunching))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SuccessPunching $successPunching)
    {
        abort_if(Gate::denies('success_punching_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $successPunching->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
