<?php

namespace App\Http\Requests;

use App\Models\OfficeLocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOfficeLocationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('office_location_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:office_locations,id',
        ];
    }
}
