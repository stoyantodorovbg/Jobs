@extends('layouts.main')

@section('nav')
    @parent
    <a href="{{ route('home.index') }}">All job advertisements</a>
@endsection

<h1>Edit a job advertisement</h1>

@section('content')


        <form action="{{ route('jobs.update', $job) }}"
              method="POST"
        >

        {!! csrf_field() !!}

        <input name="_method" type="hidden" value="PUT">
        <label>Title: </label>
        <input type="text" name="title" value="{{ $job->title }}">
        <br>
        <label>Description: </label>
        <input type="text" name="description"  value="{{ $job->description }}">
        <br>
        <input type="submit" value="Edit">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection