<?php

namespace App\Http\Requests;

use App\Models\Ddo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDdoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ddo_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:ddos,code,' . request()->route('ddo')->id,
            ],
            'office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
