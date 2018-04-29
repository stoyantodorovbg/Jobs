
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
    function initMap() {
        var coordinates_arr = JSON.parse('{!! json_encode($advertisement->coordinates) !!}').split(', ');
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


