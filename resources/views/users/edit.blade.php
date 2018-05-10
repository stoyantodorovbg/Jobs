@extends('layouts.main')

@section('title')
    User edit
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

    <h1>Edit a profile</h1>

    <form action="{{ route('users.update', $user) }}"
          method="POST"
    >

        {!! csrf_field() !!}

        <input name="_method" type="hidden" value="PUT">
        <label>Name: </label>
        <input type="name" name="name" value="{{ $user->name }}">
        <br>
        <label>Email: </label>
        <input type="email" name="email" value="{{ $user->email }}">
        <br /><br />
        <input type="submit" value="Edit">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection
