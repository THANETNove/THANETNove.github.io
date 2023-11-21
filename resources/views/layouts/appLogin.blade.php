<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')


</head>

<body>

    @yield('content')


    @include('layouts.script')
</body>

</html>
