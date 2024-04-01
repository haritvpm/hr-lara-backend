<?php

namespace App\Http\Requests;

use App\Models\OvertimeOther;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOvertimeOtherRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('overtime_other_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:overtime_others,id',
        ];
    }
}
