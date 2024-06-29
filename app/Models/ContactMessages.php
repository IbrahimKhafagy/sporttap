<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessages extends Model
{
    use HasFactory;
    protected $fillable = ['provider_id', 'title', 'message', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
