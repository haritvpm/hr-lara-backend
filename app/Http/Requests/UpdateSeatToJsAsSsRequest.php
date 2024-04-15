<?php

namespace App\Http\Requests;

use App\Models\SeatToJsAsSs;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSeatToJsAsSsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seat_to_js_as_ss_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
