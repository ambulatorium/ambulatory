<?php

namespace Ambulatory\Http\Controllers\Auth;

use Ambulatory\Http\Controllers\Controller;
use Ambulatory\Mail\ResetPasswordEmail;
use Ambulatory\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetRequestForm()
    {
        return view('ambulatory::auth.request-password-reset');
    }

    /**
     * Send password reset email.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail()
    {
        validator(request()->all(), [
            'email' => 'required|email',
        ])->validate();

        if ($user = User::whereEmail(request('email'))->first()) {
            cache(['password.reset.'.$user->id => $token = Str::random()],
                now()->addMinutes(60)
            );

            Mail::to($user->email)->send(new ResetPasswordEmail(
                encrypt($user->id.'|'.$token)
            ));
        }

        return redirect()->route('ambulatory.password.forgot')->with('passwordResetLinkSent', true);
    }

    /**
     * Show the new password to the user.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function showNewPassword($token)
    {
        try {
            $token = decrypt($token);

            [$userId, $token] = explode('|', $token);

            $user = User::findOrFail($userId);
        } catch (Throwable $e) {
            return redirect()->route('ambulatory.password.forgot')->with('invalidResetToken', true);
        }

        if (cache('password.reset.'.$userId) != $token) {
            return redirect()->route('ambulatory.password.forgot')->with('invalidResetToken', true);
        }

        cache()->forget('password.reset.'.$userId);

        $user->password = Hash::make($password = Str::random());

        $user->save();

        return view('ambulatory::auth.reset-password', [
            'password' => $password,
        ]);
    }
}
