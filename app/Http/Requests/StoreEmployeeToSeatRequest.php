<?php

namespace App\Http\Requests;

use App\Models\EmployeeToSeat;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeToSeatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_seat_create');
    }

    public function rules()
    {
        return [
            'seat_id' => [
                'required',
                'integer',
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
        ];
    }
}