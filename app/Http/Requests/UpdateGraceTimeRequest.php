<?php

namespace App\Http\Requests;

use App\Models\GraceTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateGraceTimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_time_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:grace_times,title,' . request()->route('grace_time')->id,
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
