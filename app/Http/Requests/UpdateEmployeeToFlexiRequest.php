<?php

namespace App\Http\Requests;

use App\Models\EmployeeToFlexi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeToFlexiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_section_access');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'flexi_minutes' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'with_effect_from' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
