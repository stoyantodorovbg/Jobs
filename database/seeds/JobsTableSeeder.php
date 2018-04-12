<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = factory('App\Job', 5)->create();

        $candidate_data = factory('App\Candidate')->make()->toArray();

        foreach ($jobs as $job)
        {
            $job->candidates()->create($candidate_data);
        }
    }
}
