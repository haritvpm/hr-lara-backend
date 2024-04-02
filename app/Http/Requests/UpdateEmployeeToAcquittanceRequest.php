<?php

namespace App\Http\Requests;

use App\Models\EmployeeToAcquittance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeToAcquittanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_acquittance_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'acquittance_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
