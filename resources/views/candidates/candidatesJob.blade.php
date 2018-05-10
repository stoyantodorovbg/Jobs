@extends('layouts.main')

@section('title')
    Candidates for certain job
@endsection

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a class="navbar-brand" href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')
    <p>
        Order by:
        <a href="{{ route('candidates.candidatesJob', ['orderBy' => 'asc', 'job' => $job]) }}">
            Ascending
        </a>
        <a href="{{ route('candidates.candidatesJob', ['orderBy' => 'desc', 'job' => $job]) }}">
            Descending
        </a>
    </p>

    <h1>Job's candidates:</h1>
    @foreach ($candidates as $candidate)
        {{ $candidate->name }}
        <br>
        {{ $candidate->email }}
        <br>
        <img width="100px" src="{{ asset('storage/'.$candidate->photo) }}">
        <br>
        Applied at: {{ $candidate->created_at }}
        <br>
        <a href="{{ route('candidates.show', ['candidate' => $candidate->id]) }}">
            Details
        </a>
        <br>
        ----------------------
        <br>
    @endforeach

@endsection