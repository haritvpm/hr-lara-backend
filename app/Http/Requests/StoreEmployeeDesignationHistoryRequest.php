<?php

namespace App\Http\Requests;

use App\Models\EmployeeDesignationHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeDesignationHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_designation_history_create');
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
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
