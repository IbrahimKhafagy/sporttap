<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $table = 'static_pages';

    protected $fillable = [
        'name',
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'is_active',
    ];
}
