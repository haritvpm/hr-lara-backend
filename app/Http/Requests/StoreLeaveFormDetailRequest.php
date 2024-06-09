<?php

namespace App\Http\Requests;

use App\Models\LeaveFormDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLeaveFormDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_form_detail_create');
    }

    public function rules()
    {
        return [
            'dob' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'post' => [
                'string',
                'nullable',
            ],
            'dept' => [
                'string',
                'nullable',
            ],
            'pay' => [
                'string',
                'nullable',
            ],
            'doe' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_of_confirmation' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'hra' => [
                'string',
                'nullable',
            ],
            'nature' => [
                'string',
                'nullable',
            ],
            'prefix' => [
                'string',
                'nullable',
            ],
            'suffix' => [
                'string',
                'nullable',
            ],
            'last_leave_info' => [
                'string',
                'nullable',
            ],
            'leave_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
