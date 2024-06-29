<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $language = $request->header('lang', 'en'); // Default to English if language not specified

        return [
            'id' => $this->id,
            'name' => $this->getTranslatedName($language),
            'description' => $this->getTranslatedDescription($language),
            'email' => $this->email,
            'website' => $this->website,
            'provider_id' => $this->provider_id,
            'phone' => $this->phone,
            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'address_details' => $this->address_details,
            'services' => $this->services,
            'social' => $this->social,
            'status' => $this->status,
            'logo' => $this->logo,
            'images' => $this->images,
            'playgrounds' => $this->playgrounds ? PlaygroundResource::collection($this->playgrounds) : [],
            'working_hours' => $this->workingHours ? WorkingHourResource::collection($this->workingHours) : [],

        ];
    }

    private function getTranslatedName($language)
    {
        return [
            'ar' => $this->name_ar,
            'en' => $this->name_en,
        ][$language];
    }

    private function getTranslatedDescription($language)
    {
        return [
            'ar' => $this->desc_ar,
            'en' => $this->desc_en,
        ][$language];
    }

}
