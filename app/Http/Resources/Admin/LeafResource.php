<?php

namespace App\Http\Resources\Admin;
use App\Models\CompenGranted;

use Illuminate\Http\Resources\Json\JsonResource;

class LeafResource extends JsonResource
{
    public function toArray($request)
    {
       return parent::toArray($request);
    }
}
