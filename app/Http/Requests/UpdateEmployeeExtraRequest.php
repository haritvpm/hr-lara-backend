<?php

namespace App\Http\Requests;

use App\Models\EmployeeExtra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_extra_edit');
    }

    public function rules()
    {
        return [
            'date_of_joining_kla' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'pan' => [
                'string',
                'min:10',
                'required',
                'unique:employee_extras,pan,' . request()->route('employee_extra')->id,
            ],
            'klaid' => [
                'string',
                'required',
                'unique:employee_extras,klaid,' . request()->route('employee_extra')->id,
            ],
            'electionid' => [
                'string',
                'required',
                'unique:employee_extras,electionid,' . request()->route('employee_extra')->id,
            ],
            'mobile' => [
                'string',
                'min:10',
                'required',
                'unique:employee_extras,mobile,' . request()->route('employee_extra')->id,
            ],
        ];
    }
}
