<?php

namespace App\Http\Requests;

use App\Models\SuccessPunching;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSuccessPunchingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('success_punching_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'punch_in' => [
                'string',
                'required',
            ],
            'punch_out' => [
                'string',
                'required',
            ],
            'pen' => [
                'string',
                'required',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'in_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'out_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'at_type' => [
                'string',
                'nullable',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
            'aadhaarid' => [
                'string',
                'required',
            ],
        ];
    }
}
