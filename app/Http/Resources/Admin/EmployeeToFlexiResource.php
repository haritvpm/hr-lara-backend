<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeToFlexiResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
