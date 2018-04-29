<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    {{--<!-- Styles -->--}}
    {{--<link href="{{ asset('../../../public/css/main.css') }}"  rel="stylesheet"  type="text/css">--}}

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
        <a href="{{ route('users.index') }}">
            All users
        </a>
        <a href="{{ route('messages.create') }}">
            Write a message to an user
        </a>
    @endguest
@show

@section('nav')
    <a href="{{ route('advertisements.index') }}">
        All advertisements
    </a>

    <a href="{{ route('advertisements.create') }}">
        Create an advertisement
    </a>

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
