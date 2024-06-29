<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'city_id',
        'is_active',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
