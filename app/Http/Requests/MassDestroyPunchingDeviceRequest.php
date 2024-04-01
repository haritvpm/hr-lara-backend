<?php

namespace App\Http\Requests;

use App\Models\PunchingDevice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPunchingDeviceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('punching_device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:punching_devices,id',
        ];
    }
}
