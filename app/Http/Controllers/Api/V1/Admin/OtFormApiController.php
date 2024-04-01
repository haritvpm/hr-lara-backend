<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOtFormRequest;
use App\Http\Requests\UpdateOtFormRequest;
use App\Http\Resources\Admin\OtFormResource;
use App\Models\OtForm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtFormApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtFormResource(OtForm::with(['session'])->get());
    }

    public function store(StoreOtFormRequest $request)
    {
        $otForm = OtForm::create($request->all());

        return (new OtFormResource($otForm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OtForm $otForm)
    {
        abort_if(Gate::denies('ot_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtFormResource($otForm->load(['session']));
    }

    public function update(UpdateOtFormRequest $request, OtForm $otForm)
    {
        $otForm->update($request->all());

        return (new OtFormResource($otForm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OtForm $otForm)
    {
        abort_if(Gate::denies('ot_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otForm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
