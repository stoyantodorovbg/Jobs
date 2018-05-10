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

    <form action="{{ route('advertisements.update', $advertisement) }}"
          method="POST"
    >

        {!! csrf_field() !!}

        <input name="_method" type="hidden" value="PUT">
        <label>Author's name: </label>
        <input type="text" name="author_name" value="{{ $advertisement->author_name }}">
        <br>
        <label>Author's email: </label>
        <input type="text" name="author_email" value="{{ $advertisement->author_email }}">
        <br>
        <label>Title: </label>
        <input type="text" name="title" value="{{ $advertisement->title }}">
        <br>
        <label>Description: </label>
        <input type="text" name="description"  value="{{ $advertisement->description }}">
        <br>
        <label>Content: </label>
        <textarea name="content">
            {{ $advertisement->content }}
        </textarea>
        <br>
        Coordinates of preferred area:
        <textarea
                name="preferred_area"
                id="search_area"
                style="width: 200px; height: 200px"
        >
        </textarea>
        <input type="submit" value="Edit">
    </form>

    <div id="map" style="width: 400px; height: 300px"></div>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection

<script>
    var area_coordinates = [];

    /**
     * Initialize the map
     */
    function initMap() {
        var element = document.getElementById('map'),
            map_options = {
                zoom: 10,
                center: {lat: 42.698334, lng: 23.319941}, // Sofia city center
                mapTypeId: 'terrain'
            },
            map = new google.maps.Map(element, map_options);

        // Construct the polygon.
        polygon = new google.maps.Polygon({
            paths: getAreaCoordinates(),
            draggable: true,
            editable: true,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 1,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });

        // add some event listeners
        google.maps.event.addListener(polygon, "dragend", setPreferredAreaInput);
        google.maps.event.addListener(polygon.getPath(), "insert_at", setPreferredAreaInput);
        google.maps.event.addListener(polygon.getPath(), "remove_at", setPreferredAreaInput);
        google.maps.event.addListener(polygon.getPath(), "set_at", setPreferredAreaInput);


        polygon.setMap(map);

        google.maps.event.addListener(map, 'click', function (event) {
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
        });
    }

    // get the coordinates of the preferred area
    function getAreaCoordinates() {
        @if ($advertisement->preferred_area)
            var coordinates = JSON.parse('{!! json_encode($advertisement->getAreaCoordinates()) !!}');
            for (var coordinate of coordinates) {
                area_coordinates.push(new google.maps.LatLng(coordinate['lat'], coordinate['lng']))
            }
        @else
            area_coordinates = [
            new google.maps.LatLng(42.698334, 23.319941),
            new google.maps.LatLng(42.656023, 23.365434),
            new google.maps.LatLng(42.657129, 23.282088)
        ];
        @endif

        return area_coordinates;
    }

    // set search area input
    function setPreferredAreaInput() {
        var number_of_coordinates = polygon.getPath().getLength(),
            string = '';

        for (var i = 0; i < number_of_coordinates; i++) {
            string += polygon.getPath().getAt(i).toUrlValue(6) + ';\n';
        }

        document.getElementById('search_area').textContent = string;
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&callback=initMap">
</script>
