<?php

namespace App\Http\Requests;

use App\Models\OvertimeOther;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOvertimeOtherRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('overtime_other_create');
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
