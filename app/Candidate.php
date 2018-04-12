<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name', 'email', 'photo'];

    /**
     * The jobs that belong to the candidate.
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class)->withTimestamps();;

    }
}

