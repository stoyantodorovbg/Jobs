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

@section('nav')
    <a href="{{ route('jobs.create') }}">Create a job advertisement</a>
    <a href="{{ route('candidates.index') }}">All candidates</a>
@show


<br>

<div class="container">
    @yield('content')
</div>

</body>
</html>
