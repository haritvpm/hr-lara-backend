<?php

namespace App\Http\Requests;

use App\Models\EmployeeDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_detail_create');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'election' => [
                'string',
                'min:5',
                'required',
                'unique:employee_details',
            ],
            'kla_id_no' => [
                'string',
                'nullable',
            ],
        ];
    }
}
