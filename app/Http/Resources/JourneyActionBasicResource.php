<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JourneyActionBasicResource extends JsonResource
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
            'journey_activity_id' => $this->journey_activity_id,
            'action_id' => $this->action_id,
            'started_at' => $this->started_at,
            'status_id' => $this->status_id,
            'input_id' => $this->input_id,
        ];
    }
}
