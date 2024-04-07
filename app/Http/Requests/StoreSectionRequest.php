<?php

namespace App\Http\Requests;

use App\Models\Section;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('section_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:sections',
            ],
            'short_code' => [
                'string',
                'min:2',
                'required',
                'unique:sections',
            ],
            'seat_of_controling_officer_id' => [
                'required',
                'integer',
            ],
            'office_location_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
