<?php

namespace App\Http\Requests;

use App\Models\OtRouting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOtRoutingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ot_routing_create');
    }

    public function rules()
    {
        return [
            'seat_id' => [
                'required',
                'integer',
            ],
            'routing_seats.*' => [
                'integer',
            ],
            'routing_seats' => [
                'array',
            ],
            'last_forwarded_to' => [
                'string',
                'nullable',
            ],
        ];
    }
}
