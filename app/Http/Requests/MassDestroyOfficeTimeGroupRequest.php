<?php

namespace App\Http\Requests;

use App\Models\OfficeTimeGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOfficeTimeGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('office_time_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:office_time_groups,id',
        ];
    }
}
