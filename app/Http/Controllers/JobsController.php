<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyForJobRequest;
use App\Http\Requests\CreateJobRequest;
use App\Job;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateJobRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJobRequest $request)
    {
        $job = new Job();
        $job->title = $request->get('title');
        $job->description = $request->get('description');
        $job->save();

        return redirect()->route('home.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $job->viewCount = $job->viewCount + 1;
        $job->save();
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateJobRequest $request
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function update(CreateJobRequest $request, Job $job)
    {
        $job->title = $request->get('title');

        $job->description = $request->get('description');

        $job->save();

        return view('jobs.show', compact('job'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('home.index');
    }

    /**
     *
     * Store new candidate, related to a job
     *
     * @param ApplyForJobRequest $request
     * @param Job $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apply(ApplyForJobRequest $request, Job $job)
    {
        $filename = $this->uploadImage($request, $job);

        $data = $request->only(['name', 'email']);

        $data['photo'] = $filename;

        $job->candidates()->create($data);

        return redirect()->route('home.index');
    }

    public function showApply (Job $job)
    {
        return view('jobs.showApply', compact('job'));
    }

    /**
     *
     * Upload candidate's image
     *
     * @param ApplyForJobRequest $request
     * @return string
     */
    protected function uploadImage (ApplyForJobRequest $request, Job $job)
    {
        if ($request->photo != '') {
            $photo = $request->photo;

            $filename = explode('/', $photo->store('public'));

            return $filename[1];
        } else {
           return redirect()->route('jobs.show', ['job' => $job]);
        }

        return '';
    }
}
