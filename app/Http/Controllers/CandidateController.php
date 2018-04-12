<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Http\Requests\EditCandidateRequest;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orderBy = $request->orderBy;
        if (!$orderBy) {
            $orderBy = 'desc';
        }
        $candidate = new Candidate();
        $candidates = $candidate->orderBy('created_at', $orderBy)->get();

        return view('candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('candidates.create');
    }

    /**
     * Display the specified resource.
     *
     * @param Candidate $candidate
     * @return Response
     */
    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Candidate $candidate
     * @return Response
     */
    public function edit(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditCandidateRequest $request
     * @param Candidate $candidate
     * @return Response
     */
    public function update(EditCandidateRequest $request, Candidate $candidate)
    {
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
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return redirect()->route('candidates.index');
    }

    /**
     *
     * Display all candidates per one job
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
