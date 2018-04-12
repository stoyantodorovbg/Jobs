
@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">All job advertisements</a>
@endsection

@section('content')

    <h1>Job</h1>

    Job title: {{ $job->title }}
    <br>
    Job description: {{ $job->description }}
    <br>
    <a href="{{ route('jobs.edit', ['job' => $job->id]) }}">Edit</a>
    <br>
    <form action="{{ url('jobs', ['id' => $job->id]) }}"
          method="post"
    >

        {!! csrf_field() !!}

        <input type="hidden" name="_method" value="delete" />
        <input type="submit" value="Delete">
    </form>

    <br>
    Views: {{ $job->viewCount }}

    <h3>Candidates:</h3>

    @foreach ($job->candidates as $candidate)
        {{ $candidate->name }},
    @endforeach

    <br><br>

    <h2>Apply</h2>

    <form action="{{ route('jobs.apply', $job) }}"
          method="post"
          enctype="multipart/form-data"
    >
        {{ csrf_field() }}


        <label>Name: </label>
        <input type="text" name="name" value="{{ old('name') }}">
        <br>
        <label>Email: </label>
        <input type="text" name="email" value="{{ old('email') }}">
        <br>
        <label>Image: </label>
        <input type="file" name="photo">
        <br /><br />
        <input type="submit" value="Apply">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection

