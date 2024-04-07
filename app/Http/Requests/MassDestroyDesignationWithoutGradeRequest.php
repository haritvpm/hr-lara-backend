<?php

namespace App\Http\Requests;

use App\Models\DesignationWithoutGrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDesignationWithoutGradeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('designation_without_grade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:designation_without_grades,id',
        ];
    }
}
