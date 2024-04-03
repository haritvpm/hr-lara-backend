<?php

namespace App\Http\Requests;

use App\Models\TaxEntry;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTaxEntryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tax_entry_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'status' => [
                'string',
                'nullable',
            ],
            'acquittance' => [
                'string',
                'nullable',
            ],
            'sparkcode' => [
                'string',
                'nullable',
            ],
        ];
    }
}
