<?php

namespace App\Http\Requests;

use App\Models\LeaveGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLeaveGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leaf_access');
    }

    public function rules()
    {
        return [
            'groupname' => [
                'string',
                'required',
                'unique:leave_groups,groupname,' . request()->route('leave_group')->id,
            ],
            'allowed_casual_per_year' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'allowed_compen_per_year' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'allowed_special_casual_per_year' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'allowed_earned_per_year' => [
                'string',
                'nullable',
            ],
            'allowed_halfpay_per_year' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'allowed_continuous_casual_and_compen' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
