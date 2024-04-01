<?php

namespace App\Http\Requests;

use App\Models\OtCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOtCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ot_category_create');
    }

    public function rules()
    {
        return [
            'category' => [
                'string',
                'required',
                'unique:ot_categories',
            ],
        ];
    }
}
