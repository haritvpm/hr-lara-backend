<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeatToJsAsSsRequest;
use App\Http\Requests\UpdateSeatToJsAsSsRequest;
use App\Http\Resources\Admin\SeatToJsAsSsResource;
use App\Models\SeatToJsAsSs;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeatToJsAsSsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seat_to_js_as_ss_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeatToJsAsSsResource(SeatToJsAsSs::with(['seat', 'employee'])->get());
    }

    public function store(StoreSeatToJsAsSsRequest $request)
    {
        $seatToJsAsSs = SeatToJsAsSs::create($request->all());

        return (new SeatToJsAsSsResource($seatToJsAsSs))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SeatToJsAsSs $seatToJsAsSs)
    {
        abort_if(Gate::denies('seat_to_js_as_ss_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeatToJsAsSsResource($seatToJsAsSs->load(['seat', 'employee']));
    }

    public function update(UpdateSeatToJsAsSsRequest $request, SeatToJsAsSs $seatToJsAsSs)
    {
        $seatToJsAsSs->update($request->all());

        return (new SeatToJsAsSsResource($seatToJsAsSs))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SeatToJsAsSs $seatToJsAsSs)
    {
        abort_if(Gate::denies('seat_to_js_as_ss_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatToJsAsSs->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
