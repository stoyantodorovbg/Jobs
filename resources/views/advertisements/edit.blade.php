@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('nav')
    @parent
    <a href="{{ route('jobs.index') }}">
        All job advertisements
    </a>
@endsection

<h1>Edit a job advertisement</h1>

@section('content')

    <form action="{{ route('advertisements.update', $advertisement) }}"
          method="POST"
    >

        {!! csrf_field() !!}

        <input name="_method" type="hidden" value="PUT">
        <label>Author's name: </label>
        <input type="text" name="author_name" value="{{ $advertisement->author_name }}">
        <label>Author's email: </label>
        <br>
        <input type="text" name="author_email" value="{{ $advertisement->author_email }}">
        <label>Title: </label>
        <br>
        <input type="text" name="title" value="{{ $advertisement->title }}">
        <br>
        <label>Description: </label>
        <input type="text" name="description"  value="{{ $advertisement->description }}">
        <br>
        <label>Content: </label>
        <textarea name="content">
            {{ $advertisement->content }}
        </textarea>
        {{--<input type="hidden" name="coordinates" id="coordinates">--}}
        <input type="submit" value="Edit">
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endsection