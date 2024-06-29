<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TempMedia extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name']; // Add your model's fillable attributes

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images'); // Use the 'images' collection for storing images
    }
}
