<?php

namespace App\Policies;

use App\User;
use App\Job;
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
        $userRoles = $user->roles;

        if($user->id == $job->user_id ) {
            return true;
        }

        foreach($userRoles as $role) {
            if ($role->name == 'admin' || $role->name == 'moderator') {
                return true;
            }
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
        $userRoles = $user->roles;

        if($user->id == $job->user_id ) {
            return true;
        }

        foreach($userRoles as $role) {
            if ($role->name == 'admin' || $role->name == 'moderator') {
                return true;
            }
        }

        return false;
    }
}
