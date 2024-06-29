<?php

namespace App\Http\Resources;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerUserResource extends JsonResource
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
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'image'=>null,

            'group' => $this->group,
            'amount' => $this->amount,
            'payment' => $this->payment,
            // Add other player fields as needed
        ];
    }
}
