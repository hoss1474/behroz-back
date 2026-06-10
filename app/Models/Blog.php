<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_1',
        'image_2',
        'image_3',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImage1UrlAttribute()
    {
        return $this->image_1 ? url(Storage::url($this->image_1)) : null;
    }

    public function getImage2UrlAttribute()
    {
        return $this->image_2 ? url(Storage::url($this->image_2)) : null;
    }

    public function getImage3UrlAttribute()
    {
        return $this->image_3 ? url(Storage::url($this->image_3)) : null;
    }
}
