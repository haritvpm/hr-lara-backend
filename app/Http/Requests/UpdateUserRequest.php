<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'username' => [
                'string',
                'min:3',
                'required',
                'unique:users,username,' . request()->route('user')->id,
            ],
           
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
           
        ];
    }
}
