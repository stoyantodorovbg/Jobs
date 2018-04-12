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
     * @return mixed
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
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        $userRoles = $user->roles;
        $isAuthenticated = false;

        foreach($userRoles as $role) {
            if ($role->name == 'admin' || $role->name == 'moderator') {
                $isAuthenticated = true;
                break;
            }
        }

        return $isAuthenticated;
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\User  $user
     * @param  \App\Job  $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        $userRoles = $user->roles;
        $isAuthenticated = false;

        foreach($userRoles as $role) {
            if ($role->name == 'admin' || $role->name == 'moderator') {
                $isAuthenticated = true;
                break;
            }
        }

        return $isAuthenticated;
    }
}
