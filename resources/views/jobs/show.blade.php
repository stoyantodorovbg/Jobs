
@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a class="navbar-brand" href="{{ route('jobs.index') }}">All job advertisements</a>
@endsection

@section('content')

    <h1>Job</h1>

    Job title: {{ $job->title }}
    <br>
    Job description: {{ $job->description }}
    <br>
    Author's name: {{ $job->user->name }}
    <br>
    Author's email: {{ $job->user->email }}
    <br>

    <a href="{{ route('advertisements.findByPreferredLocation', ['location' => $job->coordinates]) }}">Search for advertisements which prefer this job location</a>

    <br>

    <div id="map" style="width: 400px; height: 300px"></div>

    <div id="address_location"></div>

    <button onclick="displayAddress()">Display the address of this location</button>


    @can('update', $job)
        <br>
        <a href="{{ route('jobs.edit', ['job' => $job->id]) }}">Edit</a>
    @endcan

    @can('delete', $job)
        <br>
        <form action="{{ url('jobs', ['id' => $job->id]) }}"
              method="post"
        >

            {!! csrf_field() !!}

            <input type="hidden" name="_method" value="delete" />
            <input type="submit" value="Delete">
        </form>
        <br>
    @endcan

    Views: {{ $job->viewCount }}

    <h3>Candidates:</h3>

    @foreach ($job->candidates as $candidate)
        {{ $candidate->name }},
    @endforeach

    <br><br>

    <h2>Apply</h2>

    <form action="{{ route('jobs.apply', $job) }}"
          method="post"
          enctype="multipart/form-data"
    >
        {{ csrf_field() }}

        <label>Name: </label>
        <input type="text" name="name" value="{{ old('name') }}">
        <br>
        <label>Email: </label>
        <input type="text" name="email" value="{{ old('email') }}">
        <br>
        <label>Image: </label>
        <input type="file" name="photo">
        <br /><br />
        <input type="submit" value="Apply">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    <a href="https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8">
        Click to see the address of this location
    </a>

@endsection

<script>
    var coordinates_arr = JSON.parse('{!! json_encode($job->coordinates) !!}').split(', '),
        coordinates = {lat: Number(coordinates_arr[0]), lng: Number(coordinates_arr[1])};

    // initializes the map on the #map div
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: coordinates
        });
        var marker = new google.maps.Marker({
            position: coordinates,
            map: map
        });
    }

    // Get and display the address of the job location
    function displayAddress() {
        $.get(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${coordinates_arr[0]},${coordinates_arr[1]}&key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8`,
        function (data) {
            var address = data['results'][0]['formatted_address'];
            $('#address_location').text(address);
        });
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&callback=initMap">
</script>


