<?php

namespace App\Http\Requests;

use App\Models\GraceTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreGraceTimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_time_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:grace_times',
            ],
            'minutes' => [
                'required',
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
