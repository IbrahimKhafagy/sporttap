<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playground extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'name_ar',
        'name_en',
        'classification',
        'player',
        'images',
        'is_active',
        'price_per_60',
        'price_per_90',
        'price_per_120',
        'price_per_180',
        'sale_price'
    ];

    protected $casts = [
        'images' => 'json',
        'is_active' => 'boolean',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    public function users()
    {
        return $this->belongsToMany(Provider::class);
    }

    public function classificationSetting()
    {
        return $this->belongsTo(PlaceSetting::class, 'classification');
    }

    public function playerSetting()
    {
        return $this->belongsTo(PlaceSetting::class, 'player');
    }

    function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $radius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c; // Distance in kilometers

        return $distance;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
