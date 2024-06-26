<?php

namespace App\Http\Requests;

use App\Models\OtFormOther;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOtFormOtherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ot_form_other_edit');
    }

    public function rules()
    {
        return [
            'creator' => [
                'string',
                'required',
            ],
            'owner' => [
                'string',
                'required',
            ],
            'submitted_by' => [
                'string',
                'nullable',
            ],
            'submitted_on' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'form_no' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'duty_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_from' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_to' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
