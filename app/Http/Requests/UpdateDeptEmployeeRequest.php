<?php

namespace App\Http\Requests;

use App\Models\DeptEmployee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDeptEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dept_employee_edit');
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
                'unique:dept_employees,pen,' . request()->route('dept_employee')->id,
            ],
        ];
    }
}
