<?php

namespace App\Http\Requests;

use App\Models\DesignationLine;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDesignationLineRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('designation_line_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:designation_lines,id',
        ];
    }
}
