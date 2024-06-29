<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Convert reservation_time to Carbon instance
        $reservationTime = Carbon::createFromFormat('H:i:s', $this->reservation_time);



        return [
                'id' => $this->id,
                'reservation_date' => $this->reservation_date,
                'time_from' => $reservationTime->format('h:i A'), // Format reservation_time
                'time_to' => $reservationTime->addMinutes($this->match_time)->format('h:i A'), // Format new reservation time
            'match_time' => $this->match_time,
            'type' => $this->type,
            'status' => $this->status,
            'playground' => new PlaygroundResource($this->playground),
            // 'user' => new UserResource($this->user),
        ];
    }
}
