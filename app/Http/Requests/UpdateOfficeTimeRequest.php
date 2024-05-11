<?php

namespace App\Http\Requests;

use App\Models\OfficeTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOfficeTimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_time_edit');
    }

    public function rules()
    {
        return [
            'groupname' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'fn_from' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'fn_to' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'an_from' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'an_to' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'flexi_minutes' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'with_effect_from' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
