<?php

namespace App\Http\Requests;

use App\Models\AssemblySession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAssemblySessionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('assembly_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:assembly_sessions,id',
        ];
    }
}
