@extends('layouts.main')

@section('nav')

    @parent

@endsection

@section('content')

    <br>

    <form action="{{ route('home.search', ['orderBy' => 'asc']) }}"
          method="post"
    >

        {!! csrf_field() !!}

        <label>Order by last update date</label>
        <select name="orderBy">
            <option>asc</option>
            <option>desc</option>
        </select>
        <br>
        <label>Order by rating</label>
        <input type="checkbox" name="rating">
        <br>
        <label>Results per page </label>
        <select name="resultsCount">
            <option>4</option>
            <option>6</option>
        </select>
        <br>
        <label>Search by key word</label>
        <input type="text" name="keyWord">
        <br>
        <label>Search by title</label>
        <input type="text" name="title">
        <br>
        <input type="submit" value="Search">
    </form>

    <h1>Job advertisements: </h1>

    @foreach ($jobs as $job)
        <section>
            Job title: {{ $job->title }}
            <br>
            Views: {{ $job->viewCount }}
            <br>
            <a href="{{ route('jobs.showApply', ['job' => $job->id]) }}">Apply</a>
            <br>
            @if (count($job->candidates) > 0 )
                <a href="{{ route('candidates.candidatesJob', ['job' => $job->id]) }}">Job's candidates: </a>
                <br>
            @endif
            Last update: {{ $job->updated_at }}
            <br>
            <a href="{{ route('jobs.show', ['job' => $job->id]) }}">Job's details</a>
            <br>
            ---------------------
            <br>
        </section>
    @endforeach

    {{ $jobs->links() }}

@endsection

