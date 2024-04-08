<?php

namespace App\Http\Requests;

use App\Models\Designation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDesignationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_edit');
    }

    public function rules()
    {
        return [
            'designation' => [
                'string',
                'required',
                'unique:designations,designation,' . request()->route('designation')->id,
            ],
            'designation_mal' => [
                'string',
                'nullable',
            ],
            'sort_index' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'has_punching' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
