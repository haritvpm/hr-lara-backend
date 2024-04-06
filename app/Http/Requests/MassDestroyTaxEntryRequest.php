<?php

namespace App\Http\Requests;

use App\Models\TaxEntry;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTaxEntryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('tax_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:tax_entries,id',
        ];
    }
}
