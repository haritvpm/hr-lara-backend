<?php

namespace App\Http\Requests;

use App\Models\AssemblySession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAssemblySessionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('assembly_session_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:assembly_sessions',
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
