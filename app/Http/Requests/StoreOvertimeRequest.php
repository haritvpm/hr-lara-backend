<?php

namespace App\Http\Requests;

use App\Models\Overtime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOvertimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('overtime_create');
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
            'slots' => [
                'string',
                'required',
            ],
        ];
    }
}
