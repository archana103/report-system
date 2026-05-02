<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'subject',
        'job_title',
        'company_name',
        'specific_research_requirement'
    ];
}
