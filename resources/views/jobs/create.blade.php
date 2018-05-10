@extends('layouts.main')

@section('title')
    Job create
@endsection

@section('nav')

    @parent

@endsection

@section('nav')
    <a class="navbar-brand" href="{{ route('jobs.index') }}">
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
    <input type="hidden" name="coordinates" id="coordinates">

    <input type="submit" onclick='getCoordinates()' value="Create">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    <div id="map" style="width: 400px; height: 300px"></div>

    <div id="address_location"></div>

    <button onClick="getLocationByAddress()">Enter an address to point a location</button>
    <input type="text" id="address" value="Bulgaria, ">

@endsection

<script>
    // initializes the map on the #map div
    var marker, map;

    function initMap() {
        var sofia = { lat: 42.698334, lng: 23.319941 };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: sofia
        });


        marker = new google.maps.Marker({
            position: sofia,
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

    // Get the job location by entered address
    function getLocationByAddress() {
        var address_input = $('#address').val();
        $.get(`https://maps.googleapis.com/maps/api/geocode/json?address=${address_input}, 2&region=es&key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8`,
            function (data) {
            var lat = data['results'][0]['geometry']['location']['lat'];
            var lng = data['results'][0]['geometry']['location']['lng'];
                var location = {
                    lat: lat,
                    lng: lng,
                };
                marker.setMap(null);
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });

                displayAddress([lat, lng]);
            });
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&callback=initMap">
</script>

