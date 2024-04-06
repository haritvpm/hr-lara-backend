<?php

namespace App\Http\Requests;

use App\Models\OfficeTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOfficeTimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('office_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:office_times,id',
        ];
    }
}
