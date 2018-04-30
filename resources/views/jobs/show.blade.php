
@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">All job advertisements</a>
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

@endsection

<script>
    // initializes the map on the #map div
    function initMap() {
        var coordinates_arr = JSON.parse('{!! json_encode($job->coordinates) !!}').split(', ');
        var coordinates = {lat: Number(coordinates_arr[0]), lng: Number(coordinates_arr[1])};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: coordinates
        });
        var marker = new google.maps.Marker({
            position: coordinates,
            map: map
        });
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&callback=initMap">
</script>


