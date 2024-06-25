<?php

namespace App\Http\Requests;

use App\Models\EmployeeToSeat;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeToSeatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_to_seat_edit');
    }

    public function rules()
    {
        return [
            //to unassign a seat and make it vacant
            /*'employee_id' => [
                'required',
                'integer',
            ],*/
            'seat_id' => [
                'required',
                'integer',
            ],
            'start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
