<?php

namespace App\Http\Requests;

use App\Models\EmployeeDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_detail_edit');
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
                'unique:employee_details,election,' . request()->route('employee_detail')->id,
            ],
            'kla_id_no' => [
                'string',
                'nullable',
            ],
        ];
    }
}
