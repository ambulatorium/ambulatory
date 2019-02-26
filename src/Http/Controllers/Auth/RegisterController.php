<?php

namespace Reliqui\Ambulatory\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Reliqui\Ambulatory\ReliquiUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Reliqui\Ambulatory\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('reliqui::auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:reliqui_users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Reliqui\Ambulatory\ReliquiUsers;
     */
    protected function create(array $data)
    {
        return ReliquiUsers::create([
            'id'       => Str::uuid(),
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Where to redirect users after register.
     *
     * @return string
     */
    public function redirectPath()
    {
        return '/'.config('reliqui.path');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('reliqui');
    }
}
