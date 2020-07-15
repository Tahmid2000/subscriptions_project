<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Subsort</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <style>
        html,
        body {
            font-family: 'Helvetica';
        }
    </style>
    @stack('css')
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container">

            <a class="navbar-brand waves-effect" href="{{url('/')}}">
                <strong class="red-text">Subsort</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                <ul class="navbar-nav mr-auto">
                    @if(Route::current()->getName() == 'home')
                    <li class="nav-item active">
                        @else
                    <li class="nav-item">
                        @endif
                        <a class="nav-link waves-effect" href="{{route('home')}}">Subscriptions
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    @if(Route::current()->getName() == 'stats')
                    <li class="nav-item active">
                        @else
                    <li class="nav-item">
                        @endif
                        <a class="nav-link waves-effect" href="{{route('stats')}}">Your Stats</a>
                        <span class="sr-only">(current)</span>
                    </li>
                    @if(Route::current()->getName() == 'calendar')
                    <li class="nav-item active">
                        @else
                    <li class="nav-item">
                        @endif
                        <a class="nav-link waves-effect" href="{{route('calendar')}}">Calendar
                            <span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item">
                        <a href="{{route('logout')}}" class="nav-link border border-light rounded waves-effect" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }} <i class="fas fa-sign-out-alt"></i>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
                @else
                <ul class="navbar-nav mr-auto">
                </ul>

                <ul class="navbar-nav nav-flex-icons">
                    @if(Route::current()->getName() == 'login')
                    <li class="nav-item mr-2 active">
                        @else
                    <li class="nav-item mr-2">
                        @endif
                        <a href="{{route('login')}}" class="nav-link border border-light rounded waves-effect">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    @if(Route::current()->getName() == 'register')
                    <li class="nav-item active">
                        @else
                    <li class="nav-item">
                        @endif
                        <a href="{{route('register')}}" class="nav-link border border-light rounded waves-effect">
                            <i class="fas fa-user"></i> Register
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="page-footer text-center font-small danger-color-dark darken-2 mt-4 wow fadeIn">
        <hr class="my-4">
        <div class="pb-4">
            <a href="https://github.com/Tahmid2000" target="_blank">
                <i class="fab fa-github mr-3"></i>
            </a>
            <a href="https://www.linkedin.com/in/tahmidimran/" target="_blank">
                <i class="fab fa-linkedin mr-3"></i>
            </a>
            © {{Carbon\Carbon::now()->year}} Tahmid
        </div>
    </footer>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js">
    </script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    @stack('js')
</body>

</html>