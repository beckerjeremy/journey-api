<?php

namespace App\Http\Resources;

use App\Http\Resources\JourneySummaryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserSummaryResource extends JsonResource
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
            'first_name' => $this->first_name,
            'family_name' => $this->family_name,
            'email' => $this->email,
            'language' => $this->language,
            'is_admin' => $this->is_admin,
            'token' => $this->token,
            'journeys' => JourneySummaryResource::collection($this->journeys),
        ];
    }
}
