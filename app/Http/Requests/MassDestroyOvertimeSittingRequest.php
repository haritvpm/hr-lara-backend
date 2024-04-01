<?php

namespace App\Http\Requests;

use App\Models\OvertimeSitting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOvertimeSittingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('overtime_sitting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:overtime_sittings,id',
        ];
    }
}
