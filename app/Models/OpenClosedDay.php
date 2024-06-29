<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenClosedDay extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'user_id',
        'playground_id',
        'is_open',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_open' => 'boolean',
    ];

    /**
     * Get the user that owns the open closed day.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the playground that the open closed day belongs to.
     */
    public function playground()
    {
        return $this->belongsTo(Playground::class);
    }
}
