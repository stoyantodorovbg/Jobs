@extends('layouts.main')

@section('auth')

    @parent

@endsection

@section('nav')

    @parent

@endsection

@section('content')
    <h1>Worker advertisements: </h1>

    @foreach ($advertisements as $advertisement)
        <section id="job{{ $advertisement->id }}">
            Advertisement title: {{ $advertisement->title }}
            <br>
            Advertisement description: {{ $advertisement->description }}
            <br>
            Last update: {{ $advertisement->updated_at }}
            <br>
            <a href="{{ route('advertisements.show', ['advertisement' => $advertisement->id]) }}">
                Advertisement's details
            </a>
            <br>
            ---------------------
            <br>
        </section>
    @endforeach

@endsection
