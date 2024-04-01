<?php

namespace App\Http\Requests;

use App\Models\PunchingRegister;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPunchingRegisterRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('punching_register_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:punching_registers,id',
        ];
    }
}
