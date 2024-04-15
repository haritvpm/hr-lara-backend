<?php

namespace App\Http\Requests;

use App\Models\PunchingTrace;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePunchingTraceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('punching_trace_create');
    }

    public function rules()
    {
        return [
            'aadhaarid' => [
                'string',
                'required',
            ],
            'org_emp_code' => [
                'string',
                'nullable',
            ],
            'device' => [
                'string',
                'nullable',
            ],
            'attendance_type' => [
                'string',
                'nullable',
            ],
            'auth_status' => [
                'string',
                'nullable',
            ],
            'err_code' => [
                'string',
                'nullable',
            ],
            'att_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'att_time' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'day_offset' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'punching_id' => [
                'required',
                'integer',
            ],
            'created_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
