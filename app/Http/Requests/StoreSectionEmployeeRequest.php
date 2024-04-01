<?php

namespace App\Http\Requests;

use App\Models\SectionEmployee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSectionEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('section_employee_create');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'date_from' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'date_to' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
