@extends('layouts.main')

@section('title')
    Advertisements index
@endsection

@section('auth')

    @parent

@endsection

@section('nav')

    @parent

@endsection

@section('content')
    <h1>Worker advertisements: </h1>

    @forelse ($advertisements as $advertisement)
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
    @empty
        <h3>There is not advertisements, which prefer this job location</h3>
    @endforelse

@endsection
