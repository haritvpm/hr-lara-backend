<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_create');
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
            'aadhaarid' => [
                'string',
                'min:8',
                'max:8',
                'required',
                'unique:employees',
            ],
            'pen' => [
                'string',
                'min:5',
                'nullable',
            ],
            'desig_display' => [
                'string',
                'nullable',
            ],
            'has_punching' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
