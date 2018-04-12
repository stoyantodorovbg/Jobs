<?php

namespace Tests\Feature;

use App\Candidate;
use App\Http\Controllers\CandidateController;
use App\Http\Requests\EditCandidateRequest;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_candidate_factory()
    {
        $factory = factory('App\Candidate');

        $candidate = $factory->create();

        $this->assertDatabaseHas('candidates', $candidate->getAttributes());
    }

    /** @test */
    public function test_delete_candidate_factory()
    {
        $factory = factory('App\Candidate');

        $candidate = $factory->create();
        $candidate->delete();

        $this->assertDatabaseMissing('candidates', $candidate->getAttributes());
    }

    /** @test */
    public function test_job_candidates_factory()
    {
        $factory = factory('App\Job');

        $job = $factory->create();
        $candidate_data = factory('App\Candidate')->make()->toArray();

        $candidate = $job->candidates()->create($candidate_data);

        $this->assertDatabaseHas('candidates', $candidate->getAttributes());
    }

    /** @test */
    public function test_candidate_model_create()
    {
        $candidate = new Candidate();

        $candidate->name = 'Candidate Test Name';
        $candidate->email = 'test@example.com';
        $candidate->photo = '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg';
        $candidate->save();

        $this->assertDatabaseHas('candidates', $candidate->getAttributes());
    }

    /** @test */
    public function test_candidate_model_delete()
    {
        $candidate = new Candidate();

        $candidate->name = 'Candidate Test Name';
        $candidate->email = 'test@example.com';
        $candidate->photo = '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg';
        $candidate->save();
        $candidate->delete();

        $this->assertDatabaseMissing('candidates', $candidate->getAttributes());
    }

    /** @test */
    public function test_candidate_model_edit()
    {
        $candidate = new Candidate();

        $candidate->name = 'Candidate Test Name';
        $candidate->email = 'test@example.com';
        $candidate->photo = '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg';
        $candidate->save();
        $candidate->name = 'Edited Test Name';
        $candidate->save();

        $this->assertDatabaseHas('candidates', $candidate->getAttributes());
    }

    /** @test */
    public function test_candidate_controller_destroy()
    {
        $controller = new CandidateController();
        $candidate = new Candidate();
        $candidate->name = 'Candidate Test Title';
        $candidate->email = 'test@example.com';
        $candidate->photo = '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg';
        $candidate->save();

        $controller->destroy($candidate);

        $this->assertDatabaseMissing('candidates', [
            'name' => 'Candidate Test Title',
            'email' => 'test@example.com',
            'photo' => '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg',
        ]);
    }

    /** @test */
    public function test_candidate_controller_upload()
    {
        $controller = new CandidateController();
        $photo = UploadedFile::fake()->create('image.jpeg');
        $candidate = new Candidate();
        $candidate->name = 'Test Name';
        $candidate->email = 'test@example.com';
        $candidate->photo = $photo;
        $candidate->save();
        $updateCandidateRequest = EditCandidateRequest::create('candidates.update', 'PUT',[
            'name' => 'Test Name',
            'email' => 'edited@example.com',
        ]);

        $controller->update($updateCandidateRequest, $candidate);

        $this->assertDatabaseHas('candidates', [
            'name' => 'Test Name',
            'email' => 'edited@example.com',
        ]);
    }
}
