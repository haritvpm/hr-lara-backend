<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPunchingDeviceRequest;
use App\Http\Requests\StorePunchingDeviceRequest;
use App\Http\Requests\UpdatePunchingDeviceRequest;
use App\Models\PunchingDevice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PunchingDeviceController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('punching_device_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punchingDevices = PunchingDevice::all();

        return view('admin.punchingDevices.index', compact('punchingDevices'));
    }

    public function create()
    {
        abort_if(Gate::denies('punching_device_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.punchingDevices.create');
    }

    public function store(StorePunchingDeviceRequest $request)
    {
        $punchingDevice = PunchingDevice::create($request->all());

        return redirect()->route('admin.punching-devices.index');
    }

    public function edit(PunchingDevice $punchingDevice)
    {
        abort_if(Gate::denies('punching_device_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.punchingDevices.edit', compact('punchingDevice'));
    }

    public function update(UpdatePunchingDeviceRequest $request, PunchingDevice $punchingDevice)
    {
        $punchingDevice->update($request->all());

        return redirect()->route('admin.punching-devices.index');
    }

    public function show(PunchingDevice $punchingDevice)
    {
        abort_if(Gate::denies('punching_device_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.punchingDevices.show', compact('punchingDevice'));
    }

    public function destroy(PunchingDevice $punchingDevice)
    {
        abort_if(Gate::denies('punching_device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $punchingDevice->delete();

        return back();
    }

    public function massDestroy(MassDestroyPunchingDeviceRequest $request)
    {
        $punchingDevices = PunchingDevice::find(request('ids'));

        foreach ($punchingDevices as $punchingDevice) {
            $punchingDevice->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
