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
            <form method="POST" action="{{ route('ambulatory.password.email') }}" class="form-horizontal">
                @csrf

                <div class="d-flex w-100 justify-content-between mb-3">
                    <h4>Reset password</h4>

                    <a href="{{ route('ambulatory.auth.login') }}"> Sign in?</a>
                </div>

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

                <div class="form-group">
                    <label for="email" class="text-muted">E-mail address</label>

                    <input id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control form-control-lg border-0 bg-light {{ $errors->first('email', 'is-invalid') }}"
                        autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="forn-group">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset</button>
                </div>

                <p class="text-center text-muted mt-5">
                    Don't have an account? <a href="{{ route('ambulatory.auth.register') }}">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>