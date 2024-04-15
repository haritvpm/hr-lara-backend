<?php

namespace App\Http\Requests;

use App\Models\EmployeeOtSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeOtSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_ot_setting_edit');
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
