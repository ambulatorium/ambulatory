@extends('ambulatory::layouts.auth')

@section('title', 'Reset password')

@section('form-content')
    <div class="d-flex w-100 justify-content-between mb-3">
        <h4>New password</h4>

        <a href="{{ route('ambulatory.login') }}"> Sign in?</a>
    </div>

    <div class="alert alert-success">
        Copy your new password, use it for your
        <a href="{{route('ambulatory.login')}}">next login</a>,
        and then reset it.

        <strong><mark>{{$password}}</mark></strong>
    </div>
@endsection