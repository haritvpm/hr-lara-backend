<?php

namespace App\Http\Resources\Admin;
use App\Models\CompenGranted;

use Illuminate\Http\Resources\Json\JsonResource;

class LeafResource extends JsonResource
{
    public function toArray($request)
    {
        $compensGranted = CompenGranted::where('leave_id', $this->id)->get();
        $inLieofDates = [];
        $inLieofMonth = null;
        if( $this->leave_type == 'compen'){
            $inLieofDates = $compensGranted->map(function($item){
                return $item->date_of_work;
            });
        } else  if( $this->leave_type == 'compen_for_extra'){
            $inLieofMonth = $compensGranted->first()->date_of_work;
        }


         return [
                'id' => $this->id,
                'aadhaarid' => $this->aadhaarid,
                'leave_cat' => $this->leave_cat,
                'leave_type' => $this->leave_type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'time_period' => $this->time_period,
                'reason' => $this->reason,
                'leave_count' => $this->leave_count,
                'active_status' => $this->active_status,
                'proceeded' => $this->proceeded,
                'created_at' => $this->created_at,
                
                'fromType' => $this->leave_cat == 'H' ? $this->time_period : 'full',
                'multipleDays' => $this->start_date != $this->end_date,
                'inLieofDates' => $inLieofDates,
                'inLieofMonth' => $inLieofMonth,

            ];

        //return parent::toArray($request);
    }
}
