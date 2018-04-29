<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_name',
        'author_email',
        'title',
        'description',
        'content',
        'preferred_area'
    ];
}
