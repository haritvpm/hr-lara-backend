<?php

namespace App\Http\Requests;

use App\Models\DeptDesignation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDeptDesignationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dept_designation_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:dept_designations',
            ],
            'max_persons' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
