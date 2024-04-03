<?php

namespace App\Http\Requests;

use App\Models\EmployeeOtData;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeOtDataRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_ot_data_create');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'ot_excel_category_id' => [
                'required',
                'integer',
            ],
        ];
    }
}