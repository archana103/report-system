<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressRelease extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'main_image',
        'thumbnail_image'
    ];
}
