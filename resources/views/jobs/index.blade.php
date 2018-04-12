<h1>Job advertisements</h1>

@foreach ($jobs as $job)
    Job title: {{ $job->title }}
    Job description: {{ $job->description }}
    <br>
    <a href="{{ route('jobs.show', ['job' => $job->id]) }}">Details</a>
    <br>
@endforeach