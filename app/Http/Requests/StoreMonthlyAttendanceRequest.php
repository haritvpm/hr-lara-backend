<?php

namespace App\Http\Requests;

use App\Models\MonthlyAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMonthlyAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('monthly_attendance_create');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'month' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'total_cl' => [
                'numeric',
                'min:0',
                'max:20',
            ],
            'total_compen' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_compen_off_granted' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
