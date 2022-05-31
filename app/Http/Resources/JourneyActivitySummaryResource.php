<?php

namespace App\Http\Resources;

use App\Http\Resources\ActivityBasicResource;
use App\Http\Resources\JourneyActionSummaryResource;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JourneyActivitySummaryResource extends JsonResource
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
            'activity' => new ActivityBasicResource($this->activity),
            'started_at' => $this->started_at,
            'status' => new StatusResource($this->status),
            'actions' => JourneyActionSummaryResource::collection($this->journey_actions),
        ];
    }
}
