@extends('layouts.main')

@section('auth')

    @parent

@endsection

@section('nav')

    @parent

@endsection

@section('content')

    <br>

    @foreach($messages as $message)
        {{ $message->content }}
    @endforeach

@endsection