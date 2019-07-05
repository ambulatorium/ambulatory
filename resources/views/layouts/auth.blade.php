<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Meta Information --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <link href='{{ mix('app.css', 'vendor/ambulatory') }}' rel='stylesheet' type='text/css'>
</head>

<body class="auth"">
    <div class="form-auth">
        {{-- header --}}
        <div class="text-center mb-5">
            <h1 class="text-uppercase">
                <a href="/" class="text-dark">{{ config('app.name') }}</a>
            </h1>

            @if(session()->has('loggedOut'))
                <p class="font-weight-bold text-success text-center">
                    You've been logged out.
                </p>
            @endif
        </div>

        {{-- content --}}
        <div class="form-card">
            @yield('form-content')
        </div>
    </div>
</body>
</html>