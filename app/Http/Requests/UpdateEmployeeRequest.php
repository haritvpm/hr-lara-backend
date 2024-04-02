<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'required',
            ],
            'name_mal' => [
                'string',
                'nullable',
            ],
            'pen' => [
                'string',
                'min:5',
                'nullable',
            ],
            'aadhaarid' => [
                'string',
                'min:8',
                'max:8',
                'required',
                'unique:employees,aadhaarid,' . request()->route('employee')->id,
            ],
            'employee_type' => [
                'required',
            ],
            'desig_display' => [
                'string',
                'nullable',
            ],
            'pan' => [
                'string',
                'nullable',
            ],
            'has_punching' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
