<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoInputBasicResoure extends JsonResource
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
            'input_id' => $this->input == null ? null : $this->input->id,
            'file_url' => $this->file_url,
            'type' => $this->type,
            'size' => $this->size,
            'duration' => $this->duration,
        ];
    }
}
