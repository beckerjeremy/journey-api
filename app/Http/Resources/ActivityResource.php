<?php

namespace App\Http\Resources;

use App\Http\Resources\ActionBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'description' => $this->description,
            'actions' => ActionBasicResource::collection($this->actions),
        ];
    }
}
