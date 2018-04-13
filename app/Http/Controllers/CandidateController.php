<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\EditCandidateRequest;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', Candidate::class);

        $orderBy = $request->orderBy;
        if (!$orderBy) {
            $orderBy = 'desc';
        }
        $candidate = new Candidate();
        $candidates = $candidate->orderBy('created_at', $orderBy)->get();

        return view('candidates.index', compact('candidates'));
    }

    /**
     * Display the specified resource.
     *
     * @param Candidate $candidate
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Candidate $candidate)
    {
        $this->authorize('view', $candidate);

        return view('candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Candidate $candidate
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Candidate $candidate)
    {
        $this->authorize('update', $candidate);

        return view('candidates.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditCandidateRequest $request
     * @param Candidate $candidate
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(EditCandidateRequest $request, Candidate $candidate)
    {
        $this->authorize('update', $candidate);

        $candidate->name = $request->get('name');
        $candidate->email = $request->get('email');
        $candidate->save();

        return redirect()->route('candidates.show', ['candidate' => $candidate]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Candidate $candidate
     * @return Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Candidate $candidate)
    {
        $this->authorize('delete', $candidate);

        $candidate->delete();

        return redirect()->route('candidates.index');
    }

    /**
     *
     * Display all candidates for one job
     *
     * @param Job $job
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function candidatesJobIndex(Request $request, Job $job)
    {
        $orderBy = $request->orderBy;
        if (!$orderBy) {
            $orderBy = 'desc';
        }
        $candidates = $job->candidates()->orderBy('created_at', $orderBy)->get();
        return view('candidates.candidatesJob', compact('candidates', 'job'));
    }

    /**
     * Search candidates by job application
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyWord = $request->keyWord;

        $jobs = Job::searchJobCandidates($keyWord);

        //$jobs = Job::with('candidates')->where('title', 'LIKE', "%$keyWord%")->get();

        return view('candidates.search', compact('jobs'));
    }
}
