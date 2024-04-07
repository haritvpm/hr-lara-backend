<?php

namespace App\Http\Requests;

use App\Models\DesignationWithoutGrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDesignationWithoutGradeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_without_grade_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:designation_without_grades,title,' . request()->route('designation_without_grade')->id,
            ],
            'title_mal' => [
                'string',
                'required',
                'unique:designation_without_grades,title_mal,' . request()->route('designation_without_grade')->id,
            ],
        ];
    }
}
