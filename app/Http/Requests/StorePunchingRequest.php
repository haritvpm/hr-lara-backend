<?php

namespace App\Http\Requests;

use App\Models\Punching;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePunchingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('punching_create');
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
            'designation' => [
                'string',
                'required',
            ],
            'grace' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'extra' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
            'calc_complete' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}