<?php

namespace App\Http\Requests;

use App\Models\AttendanceBook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAttendanceBookRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('attendance_book_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'section_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
