@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">All job advertisements</a>
@endsection

@section('content')

    <h1><Ap>    </Ap>Aply</h1>

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