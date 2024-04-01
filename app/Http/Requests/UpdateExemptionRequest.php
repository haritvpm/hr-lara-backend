<?php

namespace App\Http\Requests;

use App\Models\Exemption;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExemptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('exemption_edit');
    }

    public function rules()
    {
        return [
            'date_from' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_to' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
