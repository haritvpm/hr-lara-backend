<?php

namespace App\Http\Requests;

use App\Models\AttendanceRouting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAttendanceRoutingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('attendance_routing_edit');
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
