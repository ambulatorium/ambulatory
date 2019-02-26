<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reliqui - Login</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='{{mix('app.css', 'vendor/reliqui')}}' rel='stylesheet' type='text/css'>
</head>

<body class="mb-5">
    <div class="mt-5">
        <a href="/" class="text-center text-primary">
            <h1>RELIQUI</h1>
        </a>

        <div class="col-md-4 offset-md-4">
            @if(session()->has('loggedOut'))
                <p class="font-weight-bold text-success text-center">
                    You've been logged out.
                </p>
            @else
                <p class="font-weight-bold text-center">
                    Sign In with email
                </p>
            @endif

            <p class="text-muted">
                Don't have an account? <a href="{{route('reliqui.auth.register')}}">Sign Up</a>
            </p>

            @if ($errors->any())
                <div class="font-weight-bold text-danger text-center mb-4">
                    @if ($errors->has('email'))
                        {{ $errors->first('email') }}
                    @else
                        {{ $errors->first('password') }}
                    @endif
                </div>
            @endif

            @if (session()->has('invitationAccepted'))
                <div class="alert alert-success">
                    <strong>
                        Invitation successfully verified.
                        We have e-mailed your login account!
                    </strong>
                </div>
            @endif

            <form method="POST" action="{{route('reliqui.auth.attempt')}}" class="form-horizontal">
                @csrf

                <div class="form-group">
                    <input type="email"
                        class="form-control {{ $errors->first('email', 'is-invalid') }}"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email address"
                        autofocus>
                </div>

                <div class="form-group">
                    <input type="password"
                        class="form-control {{ $errors->first('password', 'is-invalid') }}"
                        name="password"
                        placeholder="******">
                </div>

                <div class="form-group">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <a href="{{ route('reliqui.password.forgot') }}"> Forgot Password?</a>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>