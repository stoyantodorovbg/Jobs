<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->setFilters($request);

        $jobs = Job::orderBy('updated_at', $filters['orderBy'])->paginate($filters['resultsCount']);

        return view('home.home', compact('jobs'));
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

        return view('home.home', compact('jobs'));
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
}
