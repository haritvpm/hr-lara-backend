<?php

namespace App\Http\Requests;

use App\Models\DesignationLine;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDesignationLineRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_line_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:designation_lines,title,' . request()->route('designation_line')->id,
            ],
        ];
    }
}
