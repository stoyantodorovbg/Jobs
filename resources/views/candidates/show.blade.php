@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')

    <h1>Candidate</h1>

    <p>Candidate name: {{ $candidate->name }}</p>
    <p>Candidate email: {{ $candidate->email }}</p>
    <img src="{{ asset('storage/'.$candidate->photo) }}" style="width: 100px" alt="{{ $candidate->name }}">

    <a href="{{ route('candidates.edit', ['candidate' => $candidate->id]) }}">Edit</a>

    <form action="{{ url('candidates', ['id' => $candidate->id]) }}"
          method="post">

        <input type="hidden" name="_method" value="delete" />

        {!! csrf_field() !!}
        <input type="submit" value="Delete">
    </form>

    <a href="{{ route('jobs.job-application-pdf', ['candidate' => $candidate->id]) }}">Get job application data as a .pdf file</a>

@endsection
