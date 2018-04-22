<?php

namespace App\Providers;

use App\Candidate;
use App\Mail\JobApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * When a candidate applies to a job
         */
        Candidate::created(function ($candidate) {
            $this->sendEmailForJobApplication($candidate);
        });
        parent::boot();

        //
    }

    /**
     * When a candidate applies to a job,
     * an email is automatically sent to the job advertisement owner
     */
    protected function sendEmailForJobApplication(Candidate $candidate)
    {
        $jobOwnerEmail = $candidate->employerEmail;
        Mail::to("$jobOwnerEmail")->send(new JobApplication($candidate));
    }

}
