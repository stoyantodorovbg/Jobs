<?php

namespace App\Policies;

use App\User;
use App\Candidate;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the candidates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {

            return true;
        }
    }

    /**
     * Determine whether the user can view the candidate.
     *
     * @param  \App\User  $user
     * @param  \App\Candidate  $candidate
     * @return mixed
     */
    public function view(User $user, Candidate $candidate)
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {

            return true;
        }
    }

    /**
     * Determine whether the user can update the candidate.
     *
     * @param  \App\User  $user
     * @param  \App\Candidate  $candidate
     * @return mixed
     */
    public function update(User $user, Candidate $candidate)
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {

            return true;
        }
    }

    /**
     * Determine whether the user can delete the candidate.
     *
     * @param  \App\User  $user
     * @param  \App\Candidate  $candidate
     * @return mixed
     */
    public function delete(User $user, Candidate $candidate)
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {

            return true;
        }
    }
}
