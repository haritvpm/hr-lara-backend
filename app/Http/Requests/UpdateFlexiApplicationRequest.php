<?php

namespace App\Http\Requests;

use App\Models\FlexiApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFlexiApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('flexi_application_edit');
    }

    public function rules()
    {
        return [
            'aadhaarid' => [
                'string',
                'nullable',
            ],
            'flexi_minutes' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'with_effect_from' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'owner_seat' => [
                'string',
                'nullable',
            ],
            'approved_by' => [
                'string',
                'nullable',
            ],
            'approved_on' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
