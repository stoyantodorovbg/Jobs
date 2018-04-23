<?php

namespace App\Http\Controllers;

use App\Job;
use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\ApplyForJobRequest;

class JobsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateJobRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateJobRequest $request)
    {
        $job = new Job();
        $job->title = $request->get('title');
        $job->description = $request->get('description');
        $job->coordinates = $request->get('coordinates');
        $job->user()->associate(Auth::user());
        $job->save();
        return redirect()->route('jobs.show', compact('job'));
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateJobRequest $request
     * @param Job $job
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateJobRequest $request, Job $job)
    {
        $this->authorize('update', $job);

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
        $this->authorize('update', $job);

        $job->delete();

        return redirect()->route('jobs.index');
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

        $candidate = new Candidate();
        $candidate->name = $request->get('name');
        $candidate->email = $request->get('email');
        $candidate->photo = $filename;
        $candidate->employerEmail = $job->user->email;

        $job->candidates()->save($candidate);

        return redirect()->route('jobs.index');
    }

    public function showApply (Job $job)
    {
        return view('jobs.showApply', compact('job'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->setFilters($request);

        $jobs = Job::orderBy('updated_at', $filters['orderBy'])->paginate($filters['resultsCount']);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Search jobs by title
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $filters = $this->setFilters($request);

        if ($filters['title']) {
            $jobs = Job::searchJobsByTitle($filters);
        } else {
            $jobs = Job::searchJobsByKeyWord($filters);
        }

        return view('jobs.index', compact('jobs'));
    }

    /**
     * set parameters for search
     *
     * @param Request $request
     * @return array
     */
    public function setFilters(Request $request)
    {
        $orderBy = $request->orderBy;
        $resultsCount = $request->resultsCount;
        $keyWord = $request->keyWord;
        $title = $request->title;
        $rating = $request->rating;

        if (!$orderBy) {
            $orderBy = 'desc';
        }

        if ($rating) {
            $orderColumn = 'viewCount';
        } else {
            $orderColumn = 'updated_at';
        }

        if(!$resultsCount) {
            $resultsCount = 3;
        }

        return [
            'orderBy' => $orderBy,
            'orderColumn' => $orderColumn,
            'resultsCount' => $resultsCount,
            'keyWord' => $keyWord,
            'title' => $title,
            'rating' => $rating,
        ];
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
