@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    <a href="{{ route('jobs.create') }}">
        Create a job advertisement
    </a>
    <a href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')
    <h2>Search by a job's application</h2>

    <form action="{{ route('candidates.search') }}"
          method="post"
    >

        {!! csrf_field() !!}

        <input type="text" name="keyWord">
        <input type="submit" value="Search">
    </form>

    <p>
        Order by:
        <a href="{{ route('candidates.index', ['orderBy' => 'asc']) }}">Ascending</a>
        <a href="{{ route('candidates.index', ['orderBy' => 'desc']) }}">Descending</a>
    </p>

    <h1>All candidates</h1>

    @foreach ($candidates as $candidate)
        <img width="100px" src="{{ asset('storage/'.$candidate->photo) }}">
        <br>
        Candidate name: {{ $candidate->name }}
        <br>
        Candidate email: {{ $candidate->email }}
        <br>
        <a href="{{ route('candidates.show', ['candidate' => $candidate->id]) }}">Details</a>
        <br>
        Applied at: {{ $candidate->created_at }}
        <br>
        ------------
        <br>

    @endforeach

@endsection