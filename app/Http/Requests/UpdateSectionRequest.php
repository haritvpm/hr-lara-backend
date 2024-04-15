<?php

namespace App\Http\Requests;

use App\Models\Section;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('section_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:sections,name,' . request()->route('section')->id,
            ],
            'short_code' => [
                'string',
                'min:2',
                'nullable',
            ],
            'seat_of_controlling_officer_id' => [
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
