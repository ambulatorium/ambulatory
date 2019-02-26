<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Reliqui - Register</title>

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
            <p class="font-weight-bold text-center">
                Create your {{config('app.name')}} account
            </p>

            <p class="text-muted">
                Already have an account? <a href="{{route('reliqui.auth.login')}}">Sign In</a>
            </p>

            <form method="POST" action="{{route('reliqui.auth.register.post')}}" class="form-horizontal">
                @csrf

                <div class="form-group">
                    <input type="text"
                        class="form-control {{ $errors->first('name', 'is-invalid') }}"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="name"
                        required
                        autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="email"
                        class="form-control {{ $errors->first('email', 'is-invalid') }}"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email address"
                        required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="password"
                        class="form-control {{ $errors->first('password', 'is-invalid') }}"
                        name="password"
                        placeholder="password"
                        required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="confirm password"
                        required>
                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>