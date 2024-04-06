<?php

namespace App\Http\Requests;

use App\Models\Leaf;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLeafRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:leaves,id',
        ];
    }
}
