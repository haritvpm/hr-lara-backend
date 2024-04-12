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
            'aadhaarid' => [
                'string',
                'min:8',
                'required',
            ],
            'designation' => [
                'string',
                'nullable',
            ],
            'section' => [
                'string',
                'nullable',
            ],
            'in_datetime' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'out_datetime' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'duration_sec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'grace_sec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'extra_sec' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'punching_count' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ot_sitting_mins' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ot_nonsitting_mins' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],
            'finalized_by_controller' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
