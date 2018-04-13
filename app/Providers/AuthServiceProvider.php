<?php

namespace App\Providers;

use App\Job;
use App\Candidate;
use App\Policies\JobPolicy;
use App\Policies\CandidatePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Job::class => JobPolicy::class,
        Candidate::class => CandidatePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage_user_profile', function ($user) {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')) {
                return true;
            }
            return $user->id == request()->route('user')->id;
        });
    }
}
