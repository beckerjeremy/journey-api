<?php

namespace App\Http\Resources;

use App\Http\Resources\StatusResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JourneyResource extends JsonResource
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
            'name' => $this->name,
            'started_at' => $this->started_at,
            'status' => new StatusResource($this->status),
            'user' => new UserResource($this->user),
        ];
    }
}
