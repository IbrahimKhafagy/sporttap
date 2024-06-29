<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'playground_id',
        'reservation_date',
        'reservation_time',
        'match_time',
        'type',
        'total_price',
        'discount',
        'coupon',
        'fees',
        'grand_total',
        'paid_amount',
        'status',

        'payment_type',
        'reason_id'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'string',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function players()
    {
        return $this->hasMany(Player::class);
    }
    public function matchDetails()
    {
        return $this->hasOne(MatchDetail::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function playground()
    {
        return $this->belongsTo(Playground::class);
    }
}
