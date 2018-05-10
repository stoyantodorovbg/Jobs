@extends('layouts.main')

@section('title')
    Messages index
@endsection

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