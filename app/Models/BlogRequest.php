<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'full_name',
        'email',
        'phone',
        'company_name',
        'country',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
