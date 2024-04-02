<?php

namespace App\Http\Requests;

use App\Models\Acquittance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAcquittanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('acquittance_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:acquittances',
            ],
            'office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
