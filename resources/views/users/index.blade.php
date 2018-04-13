@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    <a href="{{ route('jobs.create') }}">Create a job advertisement</a>
    <a href="{{ route('jobs.index') }}">All job advertisements</a>
@endsection

@section('content')

    <h1>All users</h1>

    @foreach ($users as $user)
        User name: {{ $user->name }}
        <br>
        User email: {{ $user->email }}
        <br>
        <a href="{{ route('users.show', ['user' => $user->id]) }}">Details</a>
        <br>
        ------------
        <br>


    @endforeach

@endsection