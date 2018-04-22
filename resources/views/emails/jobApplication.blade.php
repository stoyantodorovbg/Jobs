@component('mail::message')
{{ $candidate->name }} applied to your job application

@component('mail::button', ['url' => 'http://localhost/Jobs/public/candidates/' . $candidate->id])
View this candidate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
