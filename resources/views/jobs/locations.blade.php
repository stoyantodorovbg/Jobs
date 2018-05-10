@extends('layouts.main')

@section('title')
    Jobs locations
@endsection

@section('auth')

    @parent

@endsection

@section('nav')

    @parent

@endsection

@section('content')
    <br>
    <div id="map" style="width: 400px; height: 300px"></div>
    <button onclick="displaySelectedJobs()">Display selected jobs</button>

    <div id="jobs"></div>

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

        @foreach ($locations as $location)
            coordinates_arr = JSON.parse('{!! json_encode($location) !!}').split(', ');
            coordinates = {lat: Number(coordinates_arr[0]), lng: Number(coordinates_arr[1])};
            marker = new google.maps.Marker({
                position: coordinates,
                map: map
            });
        @endforeach
    }

    // Get jobs by selected coordinates
    function displaySelectedJobs() {
        var data = {'ids': filterSelectedLocations()};
        $.ajax(
            {
                type: 'GET',
                url: '{{ url('/jobs/selected') }}',
                data: data,
                success: function (result) {
                    renderSelectedJobs(result['jobs']);
                },
                error: function () {
                    console.log('error');
                }
            }
        );
    }

    // filter selected job locations
    function filterSelectedLocations() {
        var selectedLocations = [];

        @foreach ($locations as $id => $location)
        if (ifJobIsInPolygon({!! json_encode($location) !!})) {
            selectedLocations.push({!! json_encode($id) !!});
        }
        @endforeach

        return selectedLocations;
    }

    // check if a job coordinates are within selected area on the map
    function ifJobIsInPolygon(coordinates) {
        coordinateArr = coordinates.split(', ');
        var coordinate = new google.maps.LatLng(Number(coordinateArr[0]), Number(coordinateArr[1]));

        return google.maps.geometry.poly.containsLocation(coordinate, polygon);
    }

    // Display the jobs with selected coordinates on the map
    function renderSelectedJobs(jobs) {
        $('#jobs').empty();
        var title, viewCount, apply, lastUpdate, details, separator;
        for (var job of jobs) {
            title = $('<h3></h3>').text(`Title: ${job.title}`);
            viewCount = $('<p></p>').text(`Views: ${job.viewCount}`);
            apply = $('<a></a>').text('Apply').attr('href', `/jobs/${job.id}/showApply` );
            lastUpdate = $('<p></p>').text(`Last update: ${job.updated_at}`);
            details = $('<a></a>').text('Details').attr('href', `/jobs/${job.id}`);
            separator = $('<p></p>').text('---------');

            job = $('<div></div>');
            job.append(title);
            job.append(viewCount);
            job.append(apply);
            job.append(lastUpdate);
            job.append(details);
            job.append(separator);

            $('#jobs').append(job);
        }
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYzPJTTEOvCXyFKHw_kswbeFYzpfHIXJ8&libraries=geometry&callback=initMap">
</script>