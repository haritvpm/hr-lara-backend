<?php

namespace App\Http\Requests;

use App\Models\Ddo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDdoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ddo_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:ddos',
            ],
            'office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
