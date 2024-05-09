<?php

namespace App\Http\Requests;

use App\Models\EmployeeExtra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_extra_create');
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
                'unique:employee_extras',
            ],
            'klaid' => [
                'string',
                'required',
                'unique:employee_extras',
            ],
            'electionid' => [
                'string',
                'required',
                'unique:employee_extras',
            ],
            'mobile' => [
                'string',
                'min:10',
                'required',
                'unique:employee_extras',
            ],
        ];
    }
}
