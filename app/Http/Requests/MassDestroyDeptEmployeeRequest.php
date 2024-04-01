<?php

namespace App\Http\Requests;

use App\Models\DeptEmployee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDeptEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dept_employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dept_employees,id',
        ];
    }
}
