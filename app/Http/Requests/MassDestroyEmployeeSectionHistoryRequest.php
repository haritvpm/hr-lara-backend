<?php

namespace App\Http\Requests;

use App\Models\EmployeeSectionHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmployeeSectionHistoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_section_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:employee_section_histories,id',
        ];
    }
}
