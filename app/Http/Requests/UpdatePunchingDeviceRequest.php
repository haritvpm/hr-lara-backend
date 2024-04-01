<?php

namespace App\Http\Requests;

use App\Models\PunchingDevice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePunchingDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('punching_device_edit');
    }

    public function rules()
    {
        return [
            'device' => [
                'string',
                'required',
                'unique:punching_devices,device,' . request()->route('punching_device')->id,
            ],
            'loc_name' => [
                'string',
                'nullable',
            ],
            'entry_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
