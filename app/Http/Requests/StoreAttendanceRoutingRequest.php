<?php

namespace App\Http\Requests;

use App\Models\AttendanceRouting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAttendanceRoutingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('attendance_routing_create');
    }

    public function rules()
    {
        return [
            'seats.*' => [
                'integer',
            ],
            'seats' => [
                'required',
                'array',
            ],
        ];
    }
}
