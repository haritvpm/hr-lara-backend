<?php

namespace App\Http\Requests;

use App\Models\AttendanceBook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAttendanceBookRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('attendance_book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:attendance_books,id',
        ];
    }
}
