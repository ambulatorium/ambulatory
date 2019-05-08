<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reliqui Ambulatory - Reset Password</title>

    <!-- Style sheets-->
    <link href='{{ mix('app.css', 'vendor/ambulatory') }}' rel='stylesheet' type='text/css'>
</head>
<body class="auth-body">
    <div class="form-auth">
        <div class="text-center mb-5">
            <h1 class="text-uppercase">
                <a href="/" class="text-dark">{{ config('app.name') }}</a>
            </h1>
        </div>

        <div class="form-card">
            <div class="d-flex w-100 justify-content-between mb-3">
                <h4>New password</h4>

                <a href="{{ route('ambulatory.auth.login') }}"> Sign in?</a>
            </div>

            <div class="alert alert-success">
                Copy your new password, use it for your
                <a href="{{route('ambulatory.auth.login')}}">next login</a>,
                and then reset it.

                <strong><mark>{{$password}}</mark></strong>
            </div>
        </div>
    </div>
</body>
</html>