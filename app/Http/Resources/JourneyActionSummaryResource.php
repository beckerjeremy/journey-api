<?php

namespace App\Http\Resources;

use App\Http\Resources\ActionBasicResource;
use App\Http\Resources\InputResource;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JourneyActionSummaryResource extends JsonResource
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
            'action' => new ActionBasicResource($this->action),
            'started_at' => $this->started_at,
            'status' => new StatusResource($this->status),
            'input' => new InputResource($this->input),
        ];
    }
}
