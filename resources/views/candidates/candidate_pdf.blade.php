<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Candidate</title>

</head>

<body>

<p>{{ $candidate->name }}</p>
<p>{{ $candidate->email }}</p>

</body>

</html>
