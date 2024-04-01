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
            'designation_id' => [
                'required',
                'integer',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'aadhaarid' => [
                'string',
                'min:8',
                'max:8',
                'required',
                'unique:employees,aadhaarid,' . request()->route('employee')->id,
            ],
            'has_punching' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'desig_display' => [
                'string',
                'nullable',
            ],
            'pan' => [
                'string',
                'nullable',
            ],
        ];
    }
}
