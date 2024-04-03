<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTdRequest;
use App\Http\Requests\UpdateTdRequest;
use App\Http\Resources\Admin\TdResource;
use App\Models\Td;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TdsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('td_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TdResource(Td::with(['date', 'created_by'])->get());
    }

    public function store(StoreTdRequest $request)
    {
        $td = Td::create($request->all());

        return (new TdResource($td))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Td $td)
    {
        abort_if(Gate::denies('td_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TdResource($td->load(['date', 'created_by']));
    }

    public function update(UpdateTdRequest $request, Td $td)
    {
        $td->update($request->all());

        return (new TdResource($td))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Td $td)
    {
        abort_if(Gate::denies('td_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $td->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
