@extends('layouts.main')

@section('title')
    Candidates search
@endsection

@section('nav')

    @parent

@endsection

@section('nav')
    <a class="navbar-brand" href="{{ route('jobs.create') }}">
        Create a job advertisement
    </a>
    <a class="navbar-brand" href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')

    <h2>Search by job application</h2>

    <form action="{{ route('candidates.search') }}"
          method="post"
    >

        {!! csrf_field() !!}

        <input type="text" name="keyWord">
        <input type="submit" value="Search">
    </form>

    <h1>All candidates</h1>

    @foreach ($jobs as $job)

        @foreach ($job->candidates as $candidate)
            <img width="100px" src="{{ asset('storage/'.$candidate->photo) }}">
            <br>
            Candidate name: {{ $candidate->name }}
            <br>
            Candidate email: {{ $candidate->email }}
            <br>
            <a href="{{ route('candidates.show', ['candidate' => $candidate->id]) }}">Details</a>
            <br>
            ---------------------
            <br>
        @endforeach

    @endforeach

@endsection