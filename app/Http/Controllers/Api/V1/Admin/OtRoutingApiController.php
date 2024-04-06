<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOtRoutingRequest;
use App\Http\Requests\UpdateOtRoutingRequest;
use App\Http\Resources\Admin\OtRoutingResource;
use App\Models\OtRouting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtRoutingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_routing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtRoutingResource(OtRouting::with(['from_seat', 'to_seats'])->get());
    }

    public function store(StoreOtRoutingRequest $request)
    {
        $otRouting = OtRouting::create($request->all());
        $otRouting->to_seats()->sync($request->input('to_seats', []));

        return (new OtRoutingResource($otRouting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OtRouting $otRouting)
    {
        abort_if(Gate::denies('ot_routing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtRoutingResource($otRouting->load(['from_seat', 'to_seats']));
    }

    public function update(UpdateOtRoutingRequest $request, OtRouting $otRouting)
    {
        $otRouting->update($request->all());
        $otRouting->to_seats()->sync($request->input('to_seats', []));

        return (new OtRoutingResource($otRouting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OtRouting $otRouting)
    {
        abort_if(Gate::denies('ot_routing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otRouting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
