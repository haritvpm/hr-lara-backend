<?php

namespace App\Http\Requests;

use App\Models\Leaf;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLeafRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leaf_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'reason' => [
                'string',
                'nullable',
            ],
            'active_status' => [
                'string',
                'required',
            ],
            'leave_cat' => [
                'required',
            ],
            'created_by_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
