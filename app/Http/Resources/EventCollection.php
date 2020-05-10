<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EventCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name"      => $this->title,
            "color"     => $this->color,
            "parent_id" => $this->parent_id,
            "start"     => Carbon::parse($this->start_date)->format('Y-m-d'),
            "end"       => Carbon::parse($this->end_date)->format('Y-m-d'),
        ];
    }
}