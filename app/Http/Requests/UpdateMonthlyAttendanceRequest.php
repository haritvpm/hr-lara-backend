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
            'cl_marked' => [
                'numeric',
            ],
            'compen_marked' => [
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
            'total_grace_sec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_extra_sec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_grace_str' => [
                'string',
                'nullable',
            ],
            'total_extra_str' => [
                'string',
                'nullable',
            ],
            'grace_exceeded_sec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
