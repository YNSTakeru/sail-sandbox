<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
</head>

<body class="font-sans antialiased">
    <header>
        <nav class="navbar navbar-light">
            <div class="container">
                <a class="navbar-brand" href="/">conduit</a>
                <ul class="nav navbar-nav pull-xs-right">
                    <li class="nav-item">
                        <!-- Add "active" class when you're on that page" -->
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="/editor"> <i class="ion-compose"></i>&nbsp;New Article </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/settings"> <i class="ion-gear-a"></i>&nbsp;Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile/eric-simons">
                                <img src="" class="user-pic" />
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Sign in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Sign up</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </header>
    {{ $slot }}
    <footer>
        <div class="container">
            <a href="/" class="logo-font">conduit</a>
            <span class="attribution">
                An interactive learning project from <a href="https://thinkster.io">Thinkster</a>. Code &amp;
                design licensed under MIT.
            </span>
        </div>
    </footer>
</body>

</html>
