@extends('layouts.main')

@section('auth')

    @parent

@endsection

@section('nav')

    @parent

@endsection

@section('content')
    @foreach($message->users as $user)
        @if ($user->pivot->is_sent == 1)
            <p>Sender: {{ $user->name }}</p>
        @else
            <p>Receiver: {{ $user->name }}</p>
        @endif
    @endforeach

    <p>date: {{ $message->created_at }}</p>
    <p>content: {{ $message->content }}</p>

@endsection