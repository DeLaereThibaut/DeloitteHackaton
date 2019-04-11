<!DOCTYPE html>
<html class="html" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">


</head>
<body class="body">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container navcontainer">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="headerLogo" src="{{asset("images/deloitte_logo.png")}}" alt="logo"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navBox" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                        <ul class="navBox">
                            <li ><a href="{{route('home')}}"><input class="btn button {{(explode('.', Route::currentRouteName())[0]=='home' ? "active" : "" )}}"  type="submit" value="Home"></a></li>
                            <li><a href="{{route('events.list')}}"><input class="btn button {{(explode('.',Route::currentRouteName())[0]=='events' ? "active" : "" )}}" type="submit" value="Events"></a></li>
                            <li><a href="{{route('school.list')}}"><input class="btn button {{(explode('.',Route::currentRouteName())[0]=='school' ? "active" : "" )}}" type="submit" value="Schools"></a></li>
                            <li><a href="{{route('help')}}"><input class="btn button {{(explode('.',Route::currentRouteName())[0]=='help' ? "active" : "" )}}" type="submit" value="Help"></a></li>
                        </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(auth()->user()->ambassadorType=="HR")
                                    <a class="dropdown-item logout" href="{{ route('register') }}">
                                        Register new User
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item logout" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



        <main class=" mt-4">
            <div id="general_alert">
                @if(session('message'))
                    <div class="alert alert-{{(session('message_type')? session('message_type'): 'info')}}">
                        {{session('message')}}
                    </div>
                @endif
            </div>
            @yield('content')
        </main>
    </div>
</body>
</html>
