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
                Reset your password
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>
                        @if ($errors->has('email'))
                            {{ $errors->first('email') }}
                        @endif
                    </strong>
                </div>
            @endif

            @if (session()->has('invalidResetToken'))
                <div class="alert alert-danger">
                    Invalid reset token.
                </div>
            @endif

            @if (session()->has('passwordResetLinkSent'))
                <div class="alert alert-success">
                    We have e-mailed your password reset link!
                </div>
            @endif

            <form method="POST" action="{{ route('reliqui.password.email') }}" class="form-horizontal">
                @csrf

                <div class="form-group">
                    <input type="email"
                        class="form-control {{ $errors->first('email', 'is-invalid') }}"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email address"
                        autofocus>
                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Send Password Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>