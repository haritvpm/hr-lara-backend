<?php

namespace App\Http\Requests;

use App\Models\AssemblySession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAssemblySessionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('assembly_session_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:assembly_sessions,name,' . request()->route('assembly_session')->id,
            ],
            'kla_number' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'session_number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
