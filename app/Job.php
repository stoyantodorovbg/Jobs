<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'description'];

    /**
     * The candidates that belong to the job.
     */
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)->withTimestamps();;
    }

    public static function searchJobCandidates(string $keyWord)
    {
        return static::with('candidates')
            ->where('title', 'LIKE', "%$keyWord%")
            ->get();
    }

    public static function searchJobsByTitle(array $filters)
    {
        $title = $filters['title'];

        return static::where('title', 'LIKE', "%$title%")
            ->orderBy($filters['orderColumn'], $filters['orderBy'])
            ->paginate($filters['resultsCount']);
    }

    public static function searchJobsByKeyWord(array $filters)
    {
        $keyWord = $filters['keyWord'];
        return static::where('title', 'LIKE', "%$keyWord%")
            ->orWhere('description', 'LIKE', "%$keyWord%")
            ->orderBy($filters['orderColumn'], $filters['orderBy'])
            ->paginate($filters['resultsCount']);
    }
}