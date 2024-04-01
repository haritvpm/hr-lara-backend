<?php

namespace App\Http\Requests;

use App\Models\PunchingRegister;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePunchingRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('punching_register_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
            'grace_min' => [
                'string',
                'nullable',
            ],
            'extra_min' => [
                'string',
                'nullable',
            ],
            'punching_traces.*' => [
                'integer',
            ],
            'punching_traces' => [
                'array',
            ],
            'designation' => [
                'string',
                'required',
            ],
        ];
    }
}
