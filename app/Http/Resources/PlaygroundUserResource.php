<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PlaygroundUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $leastPrice = \App\Models\Playground::where('place_id', $this->id) // Assuming there's an 'is_active' column in the playgrounds table
        ->min('price_per_60');
        $media = Media::find( $this->logo);
        $filePath = "storage/{$this->logo}/$media->file_name";
        $logo=  asset("{$filePath}");

        $mediaCover = Media::find( $this->images[0]);
        $filePathCover = "storage/{$this->images[0]}/$mediaCover->file_name";
        $cover=  asset("{$filePathCover}");
        return [
            'id' => $this->id,

            'city' =>  app()->getLocale() == 'en' ? $this->city->name_en : $this->city->name_ar , // City name from place table
            'place_name' => app()->getLocale() == 'en' ? $this->name_en : $this->name_ar, // Place name based on lang
            'logo' => $logo,
            'cover'=>$cover,
            'price' => $leastPrice,
            'is_fave' => 0
        ];
    }
}
