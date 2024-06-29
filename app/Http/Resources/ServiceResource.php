<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $media=null;
        $fullUrl=null;
        $lang = $request->header('lang', 'en');
        if ($this->media_id) {
        $media = Media::find($this->media_id);
        $filePath = "storage/$this->media_id/$media->file_name";
        $fullUrl = asset("{$filePath}");
    }
        return [
            'id' => $this->id,
            'name' => $lang === 'ar' ? $this->name_ar : $this->name_en,
            'image' => $media ? $fullUrl : null,
        ];
    }
}
