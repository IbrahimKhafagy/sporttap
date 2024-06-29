<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'media_id',
        'link_id',
        'type',
        'is_active',
    ];

}
