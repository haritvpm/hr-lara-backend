<?php

namespace App\Http\Requests;

use App\Models\OtRouting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOtRoutingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ot_routing_edit');
    }

    public function rules()
    {
        return [
            'seat_id' => [
                'required',
                'integer',
            ],
            'routes' => [
                'string',
                'nullable',
            ],
            'last_forwarded_to' => [
                'string',
                'nullable',
            ],
        ];
    }
}
