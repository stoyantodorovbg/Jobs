<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('../../../public/css/main.css') }}"  rel="stylesheet"  type="text/css">

</head>
<body>

@section('auth')
    @guest
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @else
        <a href="{{route('users.show', ['user' => Auth::user()])}}"
           class="dropdown-toggle"
           data-toggle="dropdown"
           role="button"
           aria-expanded="false"
           aria-haspopup="true" v-pre
        >
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form"
              action="{{ route('logout') }}"
              method="POST" style="display: none;"
        >
            {{ csrf_field() }}
        </form>
        @if (Auth::user())
            <a href="{{ route('users.index') }}">
                All users
            </a>
        @endif
    @endguest
@show

@section('nav')
    @can('create', App\Job::class)
        <a href="{{ route('jobs.create') }}">
            Create a job advertisement
        </a>
    @endcan

    @if(Auth::user() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
        <a href="{{ route('candidates.index') }}">
            All candidates
        </a>
    @endif
@show

<br>

<div class="container">
    @yield('content')
</div>

</body>
</html>
