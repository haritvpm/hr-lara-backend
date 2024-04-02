<?php

namespace App\Http\Requests;

use App\Models\EmployeeStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmployeeStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('employee_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:employee_statuses,id',
        ];
    }
}
