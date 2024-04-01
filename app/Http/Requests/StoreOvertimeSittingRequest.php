<?php

namespace App\Http\Requests;

use App\Models\OvertimeSitting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOvertimeSittingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('overtime_sitting_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
