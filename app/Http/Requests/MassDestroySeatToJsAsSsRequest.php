<?php

namespace App\Http\Requests;

use App\Models\SeatToJsAsSs;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySeatToJsAsSsRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('seat_to_js_as_ss_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:seat_to_js_as_sses,id',
        ];
    }
}
