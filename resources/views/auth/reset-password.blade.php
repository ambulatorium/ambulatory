<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reliqui - Reset Password</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='{{mix('app.css', 'vendor/reliqui')}}' rel='stylesheet' type='text/css'>
</head>

<body class="mb-5">
    <div class="mt-5">
        <a href="/" class="text-center text-dark">
            <h1>RELIQUI</h1>
        </a>

        <div class="col-md-4 offset-md-4">
            <p class="font-weight-bold text-center">
                — Your New Password
            </p>

            <div class="alert alert-success">
                Copy your new password, use it for your
                <a href="{{route('reliqui.auth.login')}}">next login</a>,
                and then reset it.

                <strong><mark>{{$password}}</mark></strong>
            </div>
        </div>
    </div>
</body>
</html>