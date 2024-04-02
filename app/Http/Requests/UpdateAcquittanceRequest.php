<?php

namespace App\Http\Requests;

use App\Models\Acquittance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAcquittanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('acquittance_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:acquittances,title,' . request()->route('acquittance')->id,
            ],
            'office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
