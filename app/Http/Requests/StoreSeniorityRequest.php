<?php

namespace App\Http\Requests;

use App\Models\Seniority;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSeniorityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seniority_create');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'sortindex' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
