<?php

namespace App\Http\Requests;

use App\Models\EmployeeToShift;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeToShiftRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_shift_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'shift_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
