@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    <a href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')

<h1>Create a job advertisement</h1>

    <form action="{{ route('jobs.store') }}", method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <label>Title: </label>
    <input type="text" name="title">
    <br>
    <label>Description: </label>
    <input type="text" name="description">
    <br>
    <div id="map" style="width: 400px; height: 300px"></div>
    <input type="hidden" name="coordinates" id="coordinates">

    <input type="submit" onclick='getCoordinates()' value="Create">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection

<script>
    // initializes the map on the #map div
    function initMap() {
        var sofia = { lat: 42.698334, lng: 23.319941 };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: sofia
        });

        google.maps.event.addListener(map, 'click', function(event) {
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
        });
    }

    // set marker coordinates in the request
    function getCoordinates() {
        var latlng = marker.getPosition();
        document.getElementById('coordinates').setAttribute('value', latlng.lat().toFixed(6) + ', ' + latlng.lng().toFixed(6));
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&callback=initMap">
</script>

