<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'author_name',
        'image',
    ];

    public function blogDetail()
    {
        return $this->hasOne(BlogDetail::class);
    }

    public function blogRequests()
    {
        return $this->hasMany(BlogRequest::class);
    }
}
