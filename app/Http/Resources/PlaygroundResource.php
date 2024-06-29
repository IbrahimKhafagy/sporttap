<?php

namespace App\Http\Resources;

use App\Models\Media;
use App\Models\Place;
use App\Models\PlaceSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaygroundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $language = $request->header('lang', 'en'); // Default to English if language not specified
        $classificationName = PlaceSetting::find($this->classification);
        $place = Place::find($this->place_id);

        $playerName = PlaceSetting::find($this->player);
        $media = Media::find( $place->logo);
        $filePath = "storage/$place->logo/$media->file_name";
        $logo=  asset("{$filePath}");

        return [
            'id' => $this->id,
            'name' => $this->getTranslatedName($language),
            'classification' => $classificationName->getTranslatedName($language),
            'player' => $playerName->getTranslatedName($language),
            'logo' => $logo,

        ];
    }

    private function getTranslatedName($language)
    {
        return [
            'ar' => $this->name_ar,
            'en' => $this->name_en,
        ][$language];
    }
    private function getClassificationName($language)
    {
        return $this->classificationSetting
            ? $this->classificationSetting->getTranslatedName($language)
            : null;
    }
}
