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

    <h1>Create an advertisement</h1>

    <form action="{{ route('advertisements.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label>Author's name: </label>
        <input type="text" name="author_name">
        <br>
        <label>Author's email: </label>
        <input type="text" name="author_email">
        <br>
        <label>Title: </label>
        <input type="text" name="title">
        <br>
        <label>Description: </label>
        <input type="text" name="description">
        <br>
        <label>Content: </label>
        <textarea name="content">
        </textarea>
        <br>
        Coordinates of preferred area:
        <textarea
                name="preferred_area"
                id="search_area"
                style="width: 200px; height: 200px"
        >

        </textarea>
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
        //Initialize the map
        var area_coordinates = [
            new google.maps.LatLng(42.698334, 23.319941),
            new google.maps.LatLng(42.656023, 23.365434),
            new google.maps.LatLng(42.657129, 23.282088)
        ];

        var element = document.getElementById('map'),
            map_options = {
                zoom: 11,
                center: {lat: 42.698334, lng: 23.319941}, // Sofia city center
                mapTypeId: 'terrain'
            },
            map = new google.maps.Map(element, map_options);

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

        // add some event listeners
        google.maps.event.addListener(polygon, "dragend", searchPreferredAreaInput);
        google.maps.event.addListener(polygon.getPath(), "insert_at", searchPreferredAreaInput);
        google.maps.event.addListener(polygon.getPath(), "remove_at", searchPreferredAreaInput);
        google.maps.event.addListener(polygon.getPath(), "set_at", searchPreferredAreaInput);

        polygon.setMap(map);
    }

    // set search area input
    function searchPreferredAreaInput() {
        var number_of_coordinates = polygon.getPath().getLength(),
            string = '';

        for (var i = 0; i < number_of_coordinates; i++) {
            string += polygon.getPath().getAt(i).toUrlValue(6) + ';\n';
        }

        document.getElementById('search_area').textContent = string;
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&libraries=geometry&callback=initMap">
</script>

