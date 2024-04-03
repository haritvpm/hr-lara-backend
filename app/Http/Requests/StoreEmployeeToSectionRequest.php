<?php

namespace App\Http\Requests;

use App\Models\EmployeeToSection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeToSectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_section_create');
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
        ];
    }
}