<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'description'];

    /**
     * Get the candidates who belong to a job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)->withTimestamps();
    }

    /**
     * Get the user who owns the job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Search for job candidates by position, for which they applied
     *
     * @param string $keyWord
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function searchJobCandidates(string $keyWord)
    {
        return static::with('candidates')
            ->where('title', 'LIKE', "%$keyWord%")
            ->get();
    }

    /**
     * Search for job advertisements by title
     *
     * @param array $filters
     * @return mixed
     */
    public static function searchJobsByTitle(array $filters)
    {
        $title = $filters['title'];

        return static::where('title', 'LIKE', "%$title%")
            ->orderBy($filters['orderColumn'], $filters['orderBy'])
            ->paginate($filters['resultsCount']);
    }

    /**
     * Search for job advertisements by keyword
     *
     * @param array $filters
     * @return mixed
     */
    public static function searchJobsByKeyWord(array $filters)
    {
        $keyWord = $filters['keyWord'];
        return static::where('title', 'LIKE', "%$keyWord%")
            ->orWhere('description', 'LIKE', "%$keyWord%")
            ->orderBy($filters['orderColumn'], $filters['orderBy'])
            ->paginate($filters['resultsCount']);
    }
}