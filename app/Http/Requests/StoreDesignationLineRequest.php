<?php

namespace App\Http\Requests;

use App\Models\DesignationLine;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDesignationLineRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_line_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:designation_lines',
            ],
        ];
    }
}
