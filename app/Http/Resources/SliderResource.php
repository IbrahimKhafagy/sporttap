<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $media = Media::find( $this->media_id);
        $filePath = "storage/{$this->media_id}/$media->file_name";
        $image=  asset("{$filePath}");
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'link_id' => $this->link_id,
            'type' => $this->type
        ];
    }
}
