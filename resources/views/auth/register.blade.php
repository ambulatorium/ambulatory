<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reliqui Ambulatory - Register</title>

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
            <form method="POST" action="{{ route('ambulatory.register.attempt') }}" class="form-horizontal">
                @csrf

                <div class="d-flex w-100 justify-content-between mb-3">
                    <h4>Sign up</h4>

                    <a href="{{ route('ambulatory.login') }}"> Sign in?</a>
                </div>

                <div class="form-group">
                    <label for="name" class="text-muted">Name</label>

                    <input id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control form-control-lg border-0 bg-light {{ $errors->first('name', 'is-invalid') }}"
                        autofocus
                        required>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email" class="text-muted">E-mail address</label>

                    <input id="email"
                        type="email"
                        class="form-control form-control-lg border-0 bg-light {{ $errors->first('email', 'is-invalid') }}"
                        name="email"
                        required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="text-muted">Password</label>

                    <input id="password"
                        type="password"
                        class="form-control form-control-lg border-0 bg-light {{ $errors->first('password', 'is-invalid') }}"
                        name="password"
                        placeholder="******"
                        required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="text-muted">Confirm password</label>

                    <input id="password-confirm"
                        type="password"
                        class="form-control form-control-lg border-0 bg-light"
                        name="password_confirmation"
                        placeholder="******"
                        required>
                </div>

                <div class="forn-group">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
                </div>

                <p class="text-center text-muted mt-5">
                    Forgot your password?
                    <a href="{{ route('ambulatory.password.forgot') }}"> Reset!</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>