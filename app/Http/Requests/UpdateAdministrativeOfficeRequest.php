<?php

namespace App\Http\Requests;

use App\Models\AdministrativeOffice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdministrativeOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('administrative_office_edit');
    }

    public function rules()
    {
        return [
            'office_name' => [
                'string',
                'required',
                'unique:administrative_offices,office_name,' . request()->route('administrative_office')->id,
            ],
        ];
    }
}
