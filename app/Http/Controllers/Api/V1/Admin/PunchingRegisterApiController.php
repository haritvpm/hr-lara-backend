<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRegisterRequest;
use App\Http\Requests\UpdatePunchingRegisterRequest;
use App\Http\Resources\Admin\PunchingRegisterResource;
use App\Models\PunchingRegister;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PunchingRegisterApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('punching_register_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingRegisterResource(PunchingRegister::with(['employee', 'success_punching', 'punching_traces'])->get());
    }

    public function store(StorePunchingRegisterRequest $request)
    {
        $punchingRegister = PunchingRegister::create($request->all());
        $punchingRegister->punching_traces()->sync($request->input('punching_traces', []));

        return (new PunchingRegisterResource($punchingRegister))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PunchingRegister $punchingRegister)
    {
        abort_if(Gate::denies('punching_register_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingRegisterResource($punchingRegister->load(['employee', 'success_punching', 'punching_traces']));
    }

    public function update(UpdatePunchingRegisterRequest $request, PunchingRegister $punchingRegister)
    {
        $punchingRegister->update($request->all());
        $punchingRegister->punching_traces()->sync($request->input('punching_traces', []));

        return (new PunchingRegisterResource($punchingRegister))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
