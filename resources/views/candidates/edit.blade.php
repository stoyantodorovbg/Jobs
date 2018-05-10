@extends('layouts.main')

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

    <h1>Edit a candidate</h1>

    <form action="{{ route('candidates.update', $candidate) }}"
          method="POST"
    >

        {!! csrf_field() !!}

        <input name="_method" type="hidden" value="PUT">
        <label>Title: </label>
        <input type="name" name="name" value="{{ $candidate->name }}">
        <br>
        <label>Description: </label>
        <input type="email" name="email"  value="{{ $candidate->email }}">
        <br>
        <label>Image: </label>
        <input type="file" name="photo"/>
        <br /><br />
        <input type="submit" value="Edit">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection