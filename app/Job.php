<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'coordinates',
        'user_id',
    ];

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
     * @param string $key_word
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function searchJobCandidates(string $key_word)
    {
        return static::with('candidates')
            ->where('title', 'LIKE', "%$key_word%")
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
        $key_word = $filters['keyWord'];

        return static::where('title', 'LIKE', "%$key_word%")
            ->orWhere('description', 'LIKE', "%$key_word%")
            ->orderBy($filters['orderColumn'], $filters['orderBy'])
            ->paginate($filters['resultsCount']);
    }
}