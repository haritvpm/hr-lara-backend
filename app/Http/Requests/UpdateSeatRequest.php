<?php

namespace App\Http\Requests;

use App\Models\Seat;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSeatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seat_edit');
    }

    public function rules()
    {
        return [
            'slug' => [
                'string',
                'required',
                'unique:seats,slug,' . request()->route('seat')->id,
            ],
            'title' => [
                'string',
                'required',
                'unique:seats,title,' . request()->route('seat')->id,
            ],
            'level' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
