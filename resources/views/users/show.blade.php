@extends('layouts.main')

@section('title')
    User show
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

    <h1>User</h1>

    User name: {{ $user->name }}
    <br>
    User email: {{ $user->email }}
    <br><br>
    Published job advertisements:
    @forelse ($user->jobs as $job)
        <ul>
            <li>
                <a href="{{ route('jobs.show', ['job' => $job->id]) }}">
                    {{ $job->title }}
                </a>
            </li>
        </ul>
    @empty
        <p>Still you have not published any job advertisement.</p>
    @endforelse

    <a href="{{ route('users.edit', ['user' => $user->id]) }}">
        Edit
    </a>
    <br>

@endsection