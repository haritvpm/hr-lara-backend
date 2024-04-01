<?php

namespace App\Http\Requests;

use App\Models\OvertimeOther;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOvertimeOtherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('overtime_other_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'from' => [
                'string',
                'nullable',
            ],
            'to' => [
                'string',
                'nullable',
            ],
            'count' => [
                'string',
                'nullable',
            ],
        ];
    }
}
