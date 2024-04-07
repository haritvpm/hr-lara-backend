<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDdoRequest;
use App\Http\Requests\UpdateDdoRequest;
use App\Http\Resources\Admin\DdoResource;
use App\Models\Ddo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DdoApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ddo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DdoResource(Ddo::with(['office'])->get());
    }

    public function store(StoreDdoRequest $request)
    {
        $ddo = Ddo::create($request->all());

        return (new DdoResource($ddo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Ddo $ddo)
    {
        abort_if(Gate::denies('ddo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DdoResource($ddo->load(['office']));
    }

    public function update(UpdateDdoRequest $request, Ddo $ddo)
    {
        $ddo->update($request->all());

        return (new DdoResource($ddo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Ddo $ddo)
    {
        abort_if(Gate::denies('ddo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ddo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
