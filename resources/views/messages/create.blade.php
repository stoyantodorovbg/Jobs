@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    <a class="navbar-brand" href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

@section('content')

    <h1>Write a message</h1>

    <form action="{{ route('messages.store') }}",
          method="post"
    >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label>Title: </label>
        <textarea name="content"></textarea>
        <br>
        <select name="receiver_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <br>
        <input type="submit" value="Create">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection