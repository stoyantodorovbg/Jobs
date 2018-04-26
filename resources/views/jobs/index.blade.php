@extends('layouts.main')

@section('auth')

    @parent

@endsection

@section('nav')

    @parent

@endsection

@section('content')

    <br>

    <form action="{{ route('jobs.search') }}"
          method="post"
    >
        {!! csrf_field() !!}

        <label>Order by last update date</label>
        <select name="orderBy" value="desc">
            <option>desc</option>
            <option>asc</option>
        </select>
        <br>
        <label>Order by rating</label>
        <input type="checkbox" name="rating">
        <br>
        <label>Results per page </label>
        <select name="resultsCount">
            <option>10</option>
            <option>4</option>
        </select>
        <br>
        <label>Search by key word</label>
        <input type="text" name="keyWord">
        <br>
        <label>Search by title</label>
        <input type="text" name="title">
        <br>
        <input type="submit" value="Search">
    </form>

    <br>
    <div id="map" style="width: 400px; height: 300px"></div>
    <input type="hidden" name="coordinates" id="coordinates">
    <button onclick="hideOuterJobs()">Filter jobs on this page by location</button>
    <a href="{{ route('jobs.locations') }}">
        <button>View all job locations</button>
    </a>
    <br>
    <h1>Job advertisements: </h1>

    @foreach ($jobs as $job)
        <section id="job{{ $job->id }}">
            Job title: {{ $job->title }}
            <br>
            Views: {{ $job->viewCount }}
            <br>
            <a href="{{ route('jobs.showApply', ['job' => $job->id]) }}">Apply</a>
            <br>
            @if (count($job->candidates) > 0 )
                <a href="{{ route('candidates.candidatesJob', ['job' => $job->id]) }}">
                    Job's candidates:
                </a>
                <br>
            @endif
            Last update: {{ $job->updated_at }}
            <br>
            <a href="{{ route('jobs.show', ['job' => $job->id]) }}">
                Job's details
            </a>
            <br>
            ---------------------
            <br>
        </section>
    @endforeach

    {{ $jobs->links() }}

@endsection

<script>
    polygon = '';
    function initMap() {
        var sofia = { lat: 42.698334, lng: 23.319941 };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: sofia
        });

        var area_coordinates = [
            new google.maps.LatLng(42.698334, 23.319941),
            new google.maps.LatLng(42.656023, 23.365434),
            new google.maps.LatLng(42.657129, 23.282088)
        ];

        // Construct the polygon.
        polygon = new google.maps.Polygon({
            paths: area_coordinates,
            draggable: true,
            editable: true,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 1,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });

        polygon.setMap(map);

        google.maps.event.addListener(map, 'click', function(event) {
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
        });

        var marker, coordinates, coordinates_arr;

        @foreach ($jobs as $job)
        coordinates_arr = JSON.parse('{!! json_encode($job->coordinates) !!}').split(', ');
        coordinates = {lat: Number(coordinates_arr[0]), lng: Number(coordinates_arr[1])};
        marker = new google.maps.Marker({
                position: coordinates,
                map: map
            });
        @endforeach
    }

    // hide the jobs which are outside of the selected area on the map
    function hideOuterJobs() {
        @foreach ($jobs as $job)
            if (!ifJobIsInPolygon({!! json_encode($job->coordinates) !!})) {
                $('#job{{ $job->id }}').hide();
            } else {
                $('#job{{ $job->id }}').show();
            }
        @endforeach
    }

    // check if a job coordinates are within selected area on the map
    function ifJobIsInPolygon(coordinates) {
        coordinateArr = coordinates.split(', ');
        var coordinate = new google.maps.LatLng(Number(coordinateArr[0]), Number(coordinateArr[1]));

        return google.maps.geometry.poly.containsLocation(coordinate, polygon);
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&libraries=geometry&callback=initMap">
</script>

