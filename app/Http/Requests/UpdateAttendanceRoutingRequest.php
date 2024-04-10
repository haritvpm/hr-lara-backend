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
            'viewable_seats.*' => [
                'integer',
            ],
            'viewable_seats' => [
                'array',
            ],
            'viewable_js_as_ss_employees.*' => [
                'integer',
            ],
            'viewable_js_as_ss_employees' => [
                'array',
            ],
        ];
    }
}
