@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a class="navbar-brand" href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

<h1>Edit a job advertisement</h1>

@section('content')

        <form action="{{ route('jobs.update', $job) }}"
              method="POST"
        >

        {!! csrf_field() !!}

        <input name="_method" type="hidden" value="PUT">
        <label>Title: </label>
        <input type="text" name="title" value="{{ $job->title }}">
        <br>
        <label>Description: </label>
        <input type="text" name="description"  value="{{ $job->description }}">
        <br>
        <input type="hidden" name="coordinates" id="coordinates">

        <input type="submit" onclick='getCoordinates()' value="Edit">
    </form>

        <div id="map" style="width: 400px; height: 300px"></div>

        <div id="address_location"></div>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection

<script>
    var marker;

    // initializes the map on the #map div
    function initMap() {
        var coordinates_arr = JSON.parse('{!! json_encode($job->coordinates) !!}').split(', ');
        var coordinates = {lat: Number(coordinates_arr[0]), lng: Number(coordinates_arr[1])};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: coordinates
        });
        marker = new google.maps.Marker({
            position: coordinates,
            map: map
        });

        google.maps.event.addListener(map, 'click', function(event) {
            marker.setMap(null);
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
            displayAddress([event.latLng.lat(), event.latLng.lng()])
        });

        displayAddress([42.698334, 23.319941]);
    }

    // set marker coordinates in the request
    function getCoordinates() {
        var lat_lng = marker.getPosition();
        document.getElementById('coordinates').setAttribute('value', lat_lng.lat().toFixed(6) + ', ' + lat_lng.lng().toFixed(6));
    }

    // Get and display the address of the job location
    function displayAddress(coordinates_arr) {
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