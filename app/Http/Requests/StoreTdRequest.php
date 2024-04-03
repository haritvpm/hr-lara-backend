<?php

namespace App\Http\Requests;

use App\Models\Td;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTdRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('td_create');
    }

    public function rules()
    {
        return [
            'pan' => [
                'string',
                'required',
            ],
            'pen' => [
                'string',
                'required',
            ],
            'name' => [
                'string',
                'required',
            ],
            'gross' => [
                'required',
            ],
            'tds' => [
                'required',
            ],
            'slno' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'date_id' => [
                'required',
                'integer',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }
}
