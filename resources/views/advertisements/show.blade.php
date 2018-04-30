
@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">All job advertisements</a>
@endsection

@section('content')

    <h1>Advertisement</h1>

    Title: {{ $advertisement->title }}
    <br>
    Description: {{ $advertisement->description }}
    <br>
    Author's name: {{ $advertisement->author_name }}
    <br>
    Author's email: {{ $advertisement->author_email }}
    <br>

    <div id="map" style="width: 400px; height: 300px"></div>

    <a href="{{ route('advertisements.edit', ['advertisement' => $advertisement->id]) }}">Edit</a>


    <form action="{{ url('advertisements', ['id' => $advertisement->id]) }}"
          method="post"
    >
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="delete" />
        <input type="submit" value="Delete">
    </form>
    <br>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection

<script>
    polygon = '';
    function initMap() {
        var sofia = {lat: 42.698334, lng: 23.319941};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: sofia
        });

        var area_coordinates = [];

                @if ($advertisement->preferred_area)
        var coordinates_string = {!! json_encode($advertisement->preferred_area) !!};
        var coordinates_arr = extractCoordinates(coordinates_string);

        for (var coordinate of coordinates_arr) {
            area_coordinates.push(new google.maps.LatLng(coordinate[0], coordinate[1]))
        }
        @else
            area_coordinates = [
            new google.maps.LatLng(42.698334, 23.319941),
            new google.maps.LatLng(42.656023, 23.365434),
            new google.maps.LatLng(42.657129, 23.282088)
        ];
        @endif

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

        google.maps.event.addListener(map, 'click', function (event) {
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
        });
    }

    // convert a string to a matrix
    function extractCoordinates(coordinates)
    {
        var rows = coordinates.split(";\r\n");
        return rows.map(function (row) {
            return row.split(',');
        })
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&callback=initMap">
</script>


