<?php

namespace App\Http\Requests;

use App\Models\DeptEmployee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDeptEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dept_employee_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'pen' => [
                'string',
                'required',
                'unique:dept_employees',
            ],
        ];
    }
}
