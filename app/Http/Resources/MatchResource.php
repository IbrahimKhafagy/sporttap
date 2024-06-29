<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class MatchResource extends JsonResource
{
    public function toArray($request)
    { $media = Media::find( $this->playground->place->logo);
        $filePath = "storage/{$this->playground->place->logo}/$media->file_name";
        $logo=  asset("{$filePath}");
        return [
            'date' => $this->reservation_date->translatedFormat('l j F'), // Format date based on local
            'match_id' => $this->id,
            'playground_id' => $this->playground->id,

'level_num'=>  $this->level->from,
            'level' =>  app()->getLocale() == 'en' ? $this->level->name_en :  $this->level->name_ar,
            'match_time' => Carbon::parse($this->reservation_time)->format('h:i A'), // Format match time
            'price' => number_format($this->grand_total / 4, 2), // Price per player
            'match_duration' => $this->match_time, // Match duration
            'classification' =>  app()->getLocale() == 'en' ? $this->playground->classificationSetting->name_en : $this->playground->classificationSetting->name_ar, // Classification from place_settings table
            'player' =>    app()->getLocale() == 'en' ? $this->playground->playerSetting->name_en : $this->playground->playerSetting->name_ar, // Player from place_settings table
            'match_type' => $this->type,
            'city' =>  app()->getLocale() == 'en' ? $this->playground->place->city->name_en : $this->playground->place->city->name_ar , // City name from place table
            'place_name' => app()->getLocale() == 'en' ? $this->playground->place->name_en : $this->playground->place->name_ar, // Place name based on lang
            'logo' => $logo, // Logo of place
            'playground_name' =>  app()->getLocale() == 'en' ? $this->playground->name_en : $this->playground->name_ar, // Playground name
            'players' => PlayerUserResource::collection($this->players), // Players
        ];
    }
}
