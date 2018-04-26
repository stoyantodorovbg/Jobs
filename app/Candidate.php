<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $employerEmail;

    protected $fillable = [
        'name',
        'email'
    ];

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

