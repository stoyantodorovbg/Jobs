<?php

namespace Tests\Feature;

use App\Candidate;
use App\Http\Controllers\JobsController;
use App\Http\Requests\ApplyForJobRequest;
use App\Http\Requests\CreateJobRequest;
use App\Job;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_job_factory()
    {
        // given: we have a factory for a job
        $factory = factory('App\Job');

        // when: we use it to create new job
        $job = $factory->create();

        // then: we see database record
        $this->assertDatabaseHas('jobs', $job->getAttributes());
    }

    /** @test */
    public function test_delete_job_factory()
    {
        $factory = factory('App\Job');

        $job = $factory->create();
        $job->delete();

        $this->assertDatabaseMissing('jobs', $job->getAttributes());
    }

    /** @test */
    public function test_candidate_jobs_factory()
    {
        $factory = factory('App\Candidate');

        $candidate = $factory->create();
        $job_data = factory('App\Job')->make()->toArray();

        $job = $candidate->jobs()->create($job_data);

        $this->assertDatabaseHas('jobs', $job->getAttributes());
    }

    /** @test */
    public function test_job_model_create()
    {
        $job = new Job();

        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();

        $this->assertDatabaseHas('jobs', $job->getAttributes());
    }

    /** @test */
    public function test_job_model_delete()
    {
        $job = new Job();

        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();
        $job->delete();

        $this->assertDatabaseMissing('jobs', $job->getAttributes());
    }

    /** @test */
    public function test_job_model_edit()
    {
        $job = new Job();

        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();
        $job->title = 'Edited Job Title';
        $job->save();

        $this->assertDatabaseHas('jobs', $job->getAttributes());
    }

    public function test_apply_for_job()
    {
        $job = new Job();
        $candidate = new Candidate();

        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();

        $candidate->name = 'Candidate Test Name';
        $candidate->email = 'test@example.com';
        $candidate->photo = '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg';

        $job->candidates()->create($candidate->attributesToArray());
        $candidates = $job->candidates;

        $this->assertDatabaseHas('candidate_job', ['job_id' => $job->id,'candidate_id' => $candidates[0]->id]);
    }

    /** @test */
    public function test_job_controller_show()
    {
        $controller = new JobsController();
        $job = new Job();
        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();

        $controller->show($job);

        $this->assertDatabaseHas('jobs', [
            'title' => 'Job Test Title',
            'description' => 'Test job description',
            'viewCount' => 1
        ]);
    }

    /** @test */
    public function test_job_controller_destroy()
    {
        $controller = new JobsController();
        $job = new Job();
        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();

        $controller->destroy($job);

        $this->assertDatabaseMissing('jobs', [
            'title' => 'Job Test Title',
            'description' => 'Test job description'
        ]);
    }

    /** @test */
    public function test_job_controller_update()
    {
        $controller = new JobsController();
        $job = new Job();
        $job->title = 'Job Test Title';
        $job->description = 'Test job description';
        $job->save();
        $createJobRequest = CreateJobRequest::create('jobs.update', 'PUT',[
            'title'     =>     'Edited Test Title',
            'description'     =>     'Test job description',
        ]);

        $controller->update($createJobRequest, $job);

        $this->assertDatabaseHas('jobs', [
            'title' => 'Edited Test Title',
            'description' => 'Test job description'
        ]);
    }

    /** @test */
    public function test_job_controller_store()
    {
        $controller = new JobsController();
        $createJobRequest = CreateJobRequest::create('jobs.create', 'POST',[
            'title'     =>     'Test Title',
            'description'     =>     'Test job description',
        ]);

        $controller->store($createJobRequest);

        $this->assertDatabaseHas('jobs', [
            'title' => 'Test Title',
            'description' => 'Test job description'
        ]);
    }

    /** @test */
    public function test_job_controller_apply_job()
    {
        $controller = new JobsController();
        $job = new Job();
        $job->title = 'Test Title';
        $job->description = 'Test job description';
        $job->save();
        $applyJobRequest = ApplyForJobRequest::create('jobs.apply', 'POST',[
            'name' => 'Test Candidate Name',
            'email' => 'test@example.com',
        ]);

        $controller->apply($applyJobRequest, $job);

        $this->assertDatabaseHas('jobs', [
            'title' => 'Test Title',
            'description' => 'Test job description'
        ]);
    }
}
