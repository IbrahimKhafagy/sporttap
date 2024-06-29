<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassificationResource extends JsonResource
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
            'type' => $this->type,
            'is_active' => $this->is_active,
        ];
    }

    private function getTranslatedName($language)
    {
        return [
            'ar' => $this->name_ar,
            'en' => $this->name_en,
        ][$language];
    }
}
