<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'desc_ar',
        'desc_en',
        'email',
        'website',
        'provider_id',
        'phone',
        'city_id',
        'area_id',
        'lat',
        'lng',
        'address_details',
        'services',
        'social',
        'status',
        'logo',
        'images',
    ];

    protected $casts = [
        'services' => 'json',
        'social' => 'json',
        'images' => 'json',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function logoMedia()
    {
        return $this->belongsTo(Media::class, 'logo');
    }

    public function imagesMedia()
    {
        return $this->hasMany(Media::class, 'id', 'images');
    }
    public function playgrounds()
    {
        return $this->hasMany(Playground::class);
    }
    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }
}
