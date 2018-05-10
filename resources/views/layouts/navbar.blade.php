<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            @section('auth')
                @guest
                    <a class="navbar-brand" href="{{ route('login') }}">Login</a>
                    <a class="navbar-brand" href="{{ route('register') }}">Register</a>
                @else
                    <a href="{{route('users.show', ['user' => Auth::user()])}}"
                       class="dropdown-toggle navbar-brand"
                       data-toggle="dropdown"
                       role="button"
                       aria-expanded="false"
                       aria-haspopup="true" v-pre
                    >
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <a class="navbar-brand" href="{{ route('logout') }}"
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
                    <a class="navbar-brand" href="{{ route('users.index') }}">
                        All users
                    </a>
                    <a class="navbar-brand" href="{{ route('messages.create') }}">
                        Write a message to an user
                    </a>
                @endguest
            @show

            @section('nav')
                <a class="navbar-brand" href="{{ route('advertisements.index') }}">
                    All advertisements
                </a>

                <a class="navbar-brand" href="{{ route('advertisements.create') }}">
                    Create an advertisement
                </a>

                @can('create', App\Job::class)
                    <a class="navbar-brand" href="{{ route('jobs.create') }}">
                        Create a job advertisement
                    </a>
                @endcan

                @if(Auth::user() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
                    <a class="navbar-brand" href="{{ route('candidates.index') }}">
                        All candidates
                    </a>
                @endif
            @show
        </div>
    </div>
</nav>