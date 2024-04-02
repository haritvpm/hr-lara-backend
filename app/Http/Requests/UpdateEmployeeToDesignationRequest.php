<?php

namespace App\Http\Requests;

use App\Models\EmployeeToDesignation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeToDesignationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_designation_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'designation_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
