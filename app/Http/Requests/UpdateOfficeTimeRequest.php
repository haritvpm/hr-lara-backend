<?php

namespace App\Http\Requests;

use App\Models\OfficeTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOfficeTimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('office_time_edit');
    }

    public function rules()
    {
        return [
            'description' => [
                'string',
                'required',
                'unique:office_times,description,' . request()->route('office_time')->id,
            ],
            'office_id' => [
                'required',
                'integer',
            ],
            'full_from' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'full_to' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'office_hours' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'fn_from' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'fn_to' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'an_from' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'an_to' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'flexi_from' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'flexi_to' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
