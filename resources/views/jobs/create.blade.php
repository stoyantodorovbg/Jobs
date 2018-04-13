@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    <a href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')

<h1>Create a job advertisement</h1>

    <form action="{{ route('jobs.store') }}", method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <label>Title: </label>
    <input type="text" name="title">
    <br>
    <label>Description: </label>
    <input type="text" name="description">
    <br>
    <input type="submit" value="Create">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection

