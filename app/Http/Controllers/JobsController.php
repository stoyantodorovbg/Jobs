<?php

namespace App\Http\Controllers;

use App\Job;
use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\ApplyForJobRequest;
use Nitmedia\Wkhtml2pdf\Facades\Wkhtml2pdf;

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
        $job = Job::make($request->all());
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

        $job->fill($request->all());
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

        $candidate = Candidate::make($request->all());
        $candidate->photo = $filename;
        $candidate->employerEmail = $job->user->email;

        $job->candidates()->save($candidate);

        return redirect()->route('jobs.index');
    }

    public function jobApplicationPDF(Candidate $candidate)
    {
        return Wkhtml2pdf::html('candidates.candidate_pdf', compact('candidate'), 'job-application.pdf');
    }

    public function showApply (Job $job)
    {
        return view('jobs.showApply', compact('job'));
    }

    /**
     * Display a listing of the resource.
     * Search for jobs by title
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->setFilters($request);

        $jobs = $this->search($filters);

        return view('jobs.index', compact('jobs'));
    }


    /**
     * Display all job locations
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobLocations()
    {
        $locations = Job::all()->pluck('coordinates', 'id');

        return view('jobs.locations', compact('locations'));
    }

    /**
     * Retrieve jobs by selected locations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectedLocations(Request $request)
    {
        $jobs = Job::find($request->ids);

        return response()->json(array('jobs'=> $jobs), 200);
    }

    /**
     * Search by set or default filters
     *
     * @param array $filters
     * @return mixed
     */
    protected function search (array $filters)
    {
        if ($filters['title']) {

            return Job::searchJobsByTitle($filters);
        } elseif ($filters['keyWord']) {

            return Job::searchJobsByKeyWord($filters);
        }

        return Job::orderBy($filters['orderColumn'], $filters['orderBy'])->paginate($filters['resultsCount']);
    }

    /**
     * Set parameters for search
     *
     * @param Request $request
     * @return array
     */
    protected function setFilters(Request $request)
    {
        $order_by = $request->orderBy ? $request->orderBy : 'desc';
        $order_column = $request->rating ? 'viewCount': 'updated_at';
        $results_count = $request->resultsCount ? $request->resultsCount : 3;

        return [
            'orderBy' => $order_by,
            'orderColumn' => $order_column,
            'resultsCount' => $results_count,
            'keyWord' => $request->keyWord,
            'title' => $request->title,
            'rating' => $request->rating,
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
            $filename = explode('/', $request->photo->store('public'));

            return $filename[1];
        }

        return redirect()->route('jobs.show', ['job' => $job]);
    }
}
