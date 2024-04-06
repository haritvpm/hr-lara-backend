<?php

namespace App\Http\Requests;

use App\Models\OfficeLocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOfficeLocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_location_create');
    }

    public function rules()
    {
        return [
            'location' => [
                'string',
                'required',
                'unique:office_locations',
            ],
            'administrative_office_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
