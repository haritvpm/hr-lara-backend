<?php

namespace App\Http\Requests;

use App\Models\OfficeTimeGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOfficeTimeGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_time_group_create');
    }

    public function rules()
    {
        return [
            'groupname' => [
                'string',
                'required',
                'unique:office_time_groups',
            ],
        ];
    }
}
