<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Advertisement;
use App\Http\Requests\AdvertisementRequest;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::all();
        return view('advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdvertisementRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request)
    {
        $advertisement = Advertisement::make($request->all());
        $advertisement->save();

        return redirect()->route('advertisements.show', compact('advertisement'));
    }

    /**
     * Display the specified resource.
     *
     * @param Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        return view('advertisements.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        return view('advertisements.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $advertisement->fill($request->all());
        $advertisement->save();

        return redirect()->route('advertisements.show', compact('advertisement'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Advertisement $advertisement
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return redirect()->route('advertisements.index');
    }

    /**
     * Find advertisements which prefer the job location
     *
     * @param string $location
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function advertisementsForLocation(string $location)
    {
        $advertisement = new Advertisement();
        $advertisements = $advertisement->findByPreferredLocation($this->getJobCoordinates($location));

        return view('advertisements.index', compact('advertisements'));
    }

    /**
     * Convert job coordinates to an array with keys lat and lng
     *
     * @param string $location
     * @return array
     */
    protected function getJobCoordinates(string $location )
    {
        $location_arr = explode(', ', $location);
        return [
            'lat' => $location_arr[0],
            'lng' => $location_arr[1]
        ];
    }
}
