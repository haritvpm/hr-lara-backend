<?php

namespace App\Http\Requests;

use App\Models\Shift;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreShiftRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shift_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'from' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'upto' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
