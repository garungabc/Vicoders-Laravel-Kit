<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const STATUS_ACTIVE  = 1;
    const STATUS_PENDING = 0;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'parent_id',
    ];
}
