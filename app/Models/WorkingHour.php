<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'day',
        'is_open',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'is_open' => 'boolean',

    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
