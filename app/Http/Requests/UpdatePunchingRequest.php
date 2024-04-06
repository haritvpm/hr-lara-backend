<?php

namespace App\Http\Requests;

use App\Models\Punching;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePunchingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('punching_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
            'grace' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'extra' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
            'calc_complete' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ot_claimed_minutes' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'punching_status' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'designation_id' => [
                'required',
                'integer',
            ],
            'section_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
