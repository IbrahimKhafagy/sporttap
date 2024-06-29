<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ReservationDetailsResource extends JsonResource
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
        $language = $request->header('lang', 'en');



        return [
                'id' => $this->id,
                'reservation_date' => $this->getFormattedDate( $this->reservation_date,$language),
                'time_from' => $reservationTime->format('h:i A'), // Format reservation_time
                'time_to' => $reservationTime->addMinutes($this->match_time)->format('h:i A'), // Format new reservation time
            'match_time' => $this->match_time,
            'type' => $this->type,
            'status' => $this->status,
            'coupon' => $this->coupon,
            'payment_type' => $this->payment_type,
            'grand_total' => $this->grand_total,
            'paid_amount' => $this->paid_amount,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'fees' => $this->fees,
            'level_id' => $this->level_id,
            'bill'=>"",
            'user' => new UserResource($this->user),
            'playground' => new PlaygroundResource($this->playground),
            'match_details' => new MatchDetailResource($this->matchDetails),

        ];
    }

    private function getFormattedDate($date, $language)
    {
//        $today = Carbon::today()->locale($language);

        return $date->locale($language)->isoFormat('dddd, Do MMMM YYYY');
    }
}
