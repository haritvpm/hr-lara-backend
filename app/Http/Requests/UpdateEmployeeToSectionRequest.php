<?php

namespace App\Http\Requests;

use App\Models\EmployeeToSection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeToSectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_section_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'section_seat_id' => [
                'required',
                'integer',
            ],
            'attendance_book_id' => [
                'required',
                'integer',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
