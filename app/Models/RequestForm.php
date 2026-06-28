<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'specific_research_requirement',
        'report_name'
    ];
}
