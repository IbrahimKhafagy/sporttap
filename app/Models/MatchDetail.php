<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'first_round',
        'second_round',
        'third_round',
        // Add more fillable attributes here
    ];
    public function players()
    {
        return $this->hasMany(Player::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

}
