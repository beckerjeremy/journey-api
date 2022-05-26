<?php

namespace App\Http\Resources;

use App\Http\Resources\ActionBasicResource;
use App\Http\Resources\InputBasicResource;
use App\Http\Resources\JourneyActivityBasicResource;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JourneyActionResource extends JsonResource
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
            'journey_activity' => new JourneyActivityBasicResource($this->journey_activity),
            'action' => new ActionBasicResource($this->action),
            'started_at' => $this->started_at,
            'status' => new StatusResource($this->status),
            'input' => new InputResource($this->input),
        ];
    }
}
