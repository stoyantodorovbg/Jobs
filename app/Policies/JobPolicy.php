<?php

namespace App\Policies;

use App\Job;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create jobs.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return \Auth::check();
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  \App\User  $user
     * @param  \App\Job  $job
     * @return bool
     */
    public function update(User $user, Job $job)
    {
        if($user->id == $job->user_id ) {
            return true;
        }

        if ($user->hasRole('admin') || $user->hasRole('moderator')) {

            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\User  $user
     * @param  \App\Job  $job
     * @return bool
     */
    public function delete(User $user, Job $job)
    {
        if($user->id == $job->user_id ) {
            return true;
        }

        if ($user->hasRole('admin') || $user->hasRole('moderator')) {

            return true;
        }

        return false;
    }
}
