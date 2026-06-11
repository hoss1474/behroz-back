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
        'color_grade_after',
        'color_grade_before',
    ];

    public function getVideoUploadAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    public function getColorGradeAfterAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    public function getColorGradeBeforeAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }
}
