<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchDetailResource extends JsonResource
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
            // Add other match detail fields as needed
            'round_1' => $this->first_round,
            'round_2' => $this->second_round,
            'round_3' => $this->third_round,
            'players' => PlayerResource::collection($this->reservation->players),
        ];
    }
}
