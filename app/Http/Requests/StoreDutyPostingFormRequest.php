<?php

namespace App\Http\Requests;

use App\Models\DutyPostingForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDutyPostingFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('duty_posting_form_create');
    }

    public function rules()
    {
        return [
            'created_by_detail' => [
                'string',
                'nullable',
            ],
            'approver_detail' => [
                'string',
                'nullable',
            ],
            'period_from' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'period_to' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'forwarder_details' => [
                'string',
                'nullable',
            ],
            'approved_on' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'type' => [
                'required',
            ],
            'reason' => [
                'string',
                'nullable',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
