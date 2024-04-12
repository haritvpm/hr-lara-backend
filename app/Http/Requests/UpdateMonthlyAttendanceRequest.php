<?php

namespace App\Http\Requests;

use App\Models\MonthlyAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMonthlyAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('monthly_attendance_edit');
    }

    public function rules()
    {
        return [
            'aadhaarid' => [
                'string',
                'required',
            ],
            'cl_taken' => [
                'numeric',
            ],
            'compen_taken' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'compoff_granted' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
