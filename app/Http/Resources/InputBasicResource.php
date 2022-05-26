<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InputBasicResource extends JsonResource
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
            'data_type_id' => $this->data_type_id,
            'data_type_type' => $this->data_type_type,
        ];
    }
}
