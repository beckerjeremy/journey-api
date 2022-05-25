<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionBasicResource extends JsonResource
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
            'activity_id' => $this->activity_id,
            'input_type_id' => $this->input_type_id,
            'input_required' => $this->input_required,
            'name' => $this->name,
            'description' => $this->description,
            'order_weight' => $this->order_weight,
        ];
    }
}
