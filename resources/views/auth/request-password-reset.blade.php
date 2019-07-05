@extends('ambulatory::layouts.auth')

@section('title', 'Reset password')

@section('form-content')
    <div class="d-flex w-100 justify-content-between mb-3">
        <h4>Reset password</h4>

        <a href="{{ route('ambulatory.login') }}"> Sign in?</a>
    </div>

    <form method="POST" action="{{ route('ambulatory.password.email') }}" class="form-horizontal">
        @csrf

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
            Don't have an account? <a href="{{ route('ambulatory.register') }}">Sign Up</a>
        </p>
    </form>
@endsection