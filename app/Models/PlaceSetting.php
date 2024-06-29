<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getTranslatedName($language)
    {
             return $language == "ar"
                 ? $this->name_ar // or name_en, based on the language
                 : $this->name_en; // or name_en, based on the language
    }
}
