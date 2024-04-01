<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingDeviceRequest;
use App\Http\Requests\UpdatePunchingDeviceRequest;
use App\Http\Resources\Admin\PunchingDeviceResource;
use App\Models\PunchingDevice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PunchingDeviceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('punching_device_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingDeviceResource(PunchingDevice::all());
    }

    public function store(StorePunchingDeviceRequest $request)
    {
        $punchingDevice = PunchingDevice::create($request->all());

        return (new PunchingDeviceResource($punchingDevice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PunchingDevice $punchingDevice)
    {
        abort_if(Gate::denies('punching_device_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingDeviceResource($punchingDevice);
    }

    public function update(UpdatePunchingDeviceRequest $request, PunchingDevice $punchingDevice)
    {
        $punchingDevice->update($request->all());

        return (new PunchingDeviceResource($punchingDevice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PunchingDevice $punchingDevice)
    {
        abort_if(Gate::denies('punching_device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punchingDevice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
