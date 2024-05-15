<?php

namespace App\Http\Requests;

use App\Models\CompenGranted;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCompenGrantedRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('compen_granted_edit');
    }

    public function rules()
    {
        return [
            'aadhaarid' => [
                'string',
                'required',
            ],
            'date_of_work' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
