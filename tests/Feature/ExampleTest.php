<?php

namespace Tests\Feature;

use App\Candidate;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Requests\ApplyForJobRequest;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\EditCandidateRequest;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_home_controller_set_filter()
    {
        $controller = new HomeController();
        $request = Request::create('home.search', 'POST',[
            'orderBy' => 'asc',
            'orderColumn' => '',
            'resultsCount' => '4',
            'keyWord' => 'Aut',
            'title' => '',
            'rating' => 'on',
        ]);

        $expectedResult = [
            'orderBy' => 'asc',
            'orderColumn' => 'viewCount',
            'resultsCount' => '4',
            'keyWord' => 'Aut',
            'title' => null,
            'rating' => 'on',
        ];

        $result = $controller->setFilters($request);

        $this->assertTrue($result == $expectedResult);
    }

}
