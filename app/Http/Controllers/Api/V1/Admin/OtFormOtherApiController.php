<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOtFormOtherRequest;
use App\Http\Requests\UpdateOtFormOtherRequest;
use App\Http\Resources\Admin\OtFormOtherResource;
use App\Models\OtFormOther;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtFormOtherApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_form_other_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtFormOtherResource(OtFormOther::with(['session'])->get());
    }

    public function store(StoreOtFormOtherRequest $request)
    {
        $otFormOther = OtFormOther::create($request->all());

        return (new OtFormOtherResource($otFormOther))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OtFormOther $otFormOther)
    {
        abort_if(Gate::denies('ot_form_other_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtFormOtherResource($otFormOther->load(['session']));
    }

    public function update(UpdateOtFormOtherRequest $request, OtFormOther $otFormOther)
    {
        $otFormOther->update($request->all());

        return (new OtFormOtherResource($otFormOther))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OtFormOther $otFormOther)
    {
        abort_if(Gate::denies('ot_form_other_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otFormOther->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
