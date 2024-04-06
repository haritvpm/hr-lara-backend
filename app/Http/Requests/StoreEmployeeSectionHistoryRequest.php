<?php

namespace App\Http\Requests;

use App\Models\EmployeeSectionHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeSectionHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_section_history_create');
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
            'section_seat_id' => [
                'required',
                'integer',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
