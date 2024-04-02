<?php

namespace App\Http\Requests;

use App\Models\OfficeLocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOfficeLocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_location_edit');
    }

    public function rules()
    {
        return [
            'location' => [
                'string',
                'required',
                'unique:office_locations,location,' . request()->route('office_location')->id,
            ],
        ];
    }
}
