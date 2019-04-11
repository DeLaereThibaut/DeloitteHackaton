<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">


</head>
<body>
    <nav class="navMenu mb-4">
        <ul class="navBox">
            <li><form action="http://google.com"><input class="btn btn-primary" type="submit" value="test"></form></li>
            <li><input class="btn btn-primary" type="submit" value="test"></li>
            <li><input class="btn btn-primary" type="submit" value="test"></li>
            <li><input class="btn btn-primary" type="submit" value="test"></li>
        </ul>
    </nav>
    <div id="app" >
        <main class="py-4 mt-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
