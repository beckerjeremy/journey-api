<?php

namespace App\Http\Resources;

use App\Http\Resources\InputBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageInputResource extends JsonResource
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
            'input' => new InputBasicResource($this->input),
            'file_url' => $this->file_url,
            'type' => $this->type,
            'size' => $this->size,
        ];
    }
}
