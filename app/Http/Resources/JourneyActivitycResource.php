<?php

namespace App\Http\Resources;

// ToDo: import and display journey actions when implemented
use App\Http\Resources\ActivityBasicResource;
use App\Http\Resources\JourneyBasicResource;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JourneyActivitycResource extends JsonResource
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
            'journey' => new JourneyBasicResource($this->journey),
            'activity' => new ActivityBasicResource($this->activity),
            'started_at' => $this->started_at,
            'status' => new StatusResource($this->status),
        ];
    }
}
