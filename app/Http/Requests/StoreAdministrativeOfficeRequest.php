<?php

namespace App\Http\Requests;

use App\Models\AdministrativeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdministrativeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('administrative_office_create');
    }

    public function rules()
    {
        return [
            'office_name' => [
                'string',
                'required',
                'unique:administrative_offices',
            ],
        ];
    }
}
