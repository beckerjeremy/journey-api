<?php

namespace App\Http\Resources;

use App\Http\Resources\ActivityBasicResource;
use App\Http\Resources\InputTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionResource extends JsonResource
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
            'input_type' => new InputTypeResource($this->input_type),
            'input_required' => $this->input_required,
            'name' => $this->name,
            'description' => $this->description,
            'order_weight' => $this->order_weight,
        ];
    }
}
