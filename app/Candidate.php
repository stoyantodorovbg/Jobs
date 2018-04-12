<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name', 'email', 'photo'];

    /**
     * The jobs which belong to a candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class)->withTimestamps();;

    }
}

