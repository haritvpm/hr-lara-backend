<?php

namespace App\Http\Requests;

use App\Models\AttendanceRouting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAttendanceRoutingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('attendance_routing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:attendance_routings,id',
        ];
    }
}
