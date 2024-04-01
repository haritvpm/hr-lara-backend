<?php

namespace App\Http\Requests;

use App\Models\OtCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOtCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ot_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ot_categories,id',
        ];
    }
}
