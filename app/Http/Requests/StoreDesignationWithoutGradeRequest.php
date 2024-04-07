<?php

namespace App\Http\Requests;

use App\Models\DesignationWithoutGrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDesignationWithoutGradeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_without_grade_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:designation_without_grades',
            ],
            'title_mal' => [
                'string',
                'required',
                'unique:designation_without_grades',
            ],
        ];
    }
}
