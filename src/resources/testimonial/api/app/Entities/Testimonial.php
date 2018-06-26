<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    const STATUS_ACTIVE  = 1;
    const STATUS_PENDING = 0;

    protected $fillable = [
        'first_name',
        'last_name',
        'image',
        'content',
    ];
}
