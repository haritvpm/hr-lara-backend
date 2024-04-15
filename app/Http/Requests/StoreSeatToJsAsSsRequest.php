<?php

namespace App\Http\Requests;

use App\Models\SeatToJsAsSs;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSeatToJsAsSsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seat_to_js_as_ss_create');
    }

    public function rules()
    {
        return [
            'seat_id' => [
                'required',
                'integer',
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
