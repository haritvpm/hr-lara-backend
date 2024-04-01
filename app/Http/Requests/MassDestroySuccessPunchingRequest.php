<?php

namespace App\Http\Requests;

use App\Models\SuccessPunching;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySuccessPunchingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('success_punching_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:success_punchings,id',
        ];
    }
}
