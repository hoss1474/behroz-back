<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'category',
        'project_name',
        'description',
        'client',
        'data',
        'director',
        'video_upload',
        'cast',
        'color_grade',
    ];

    protected $casts = [
        'color_grade' => 'array', // برای ذخیره به‌صورت آرایه
    ];


    public function getVideoUploadUrlAttribute()
    {
        return $this->video_upload
            ? url(Storage::url($this->video_upload))
            : null;
    }
}
