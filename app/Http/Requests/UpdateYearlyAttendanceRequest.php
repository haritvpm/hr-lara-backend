<?php

namespace App\Http\Requests;

use App\Models\YearlyAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateYearlyAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('yearly_attendance_edit');
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
            'cl_submitted' => [
                'numeric',
            ],
            'compen_marked' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'compen_submitted' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'other_leaves_marked' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'other_leaves_submitted' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
