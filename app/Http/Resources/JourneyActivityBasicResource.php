<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JourneyActivityBasicResource extends JsonResource
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
            'id' => $this->id,
            'journey_id' => $this->journey_id,
            'activity_id' => $this->activity_id,
            'started_at' => $this->started_at,
            'status_id' => $this->status_id,
        ];
    }
}
