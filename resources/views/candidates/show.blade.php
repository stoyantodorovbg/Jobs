@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">All job advertisements</a>
@endsection

@section('content')

    <h1>Candidate</h1>

    Candidate name: {{ $candidate->name }}
    <br>
    Candidate email: {{ $candidate->email }}
    <br>
    <img width="100px" src="{{ asset('storage/'.$candidate->photo) }}">
    <br>

    <a href="{{ route('candidates.edit', ['candidate' => $candidate->id]) }}">Edit</a>
    <br>

    <form action="{{ url('candidates', ['id' => $candidate->id]) }}"
          method="post">

        <input type="hidden" name="_method" value="delete" />

        {!! csrf_field() !!}
        <input type="submit" value="Delete">
    </form>

@endsection