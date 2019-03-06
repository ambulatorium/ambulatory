<?php

namespace Reliqui\Ambulatory\Http\Controllers\Auth;

use Throwable;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Reliqui\Ambulatory\ReliquiUsers;
use Reliqui\Ambulatory\Mail\ResetPasswordEmail;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetRequestForm()
    {
        return view('reliqui::auth.request-password-reset');
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

        if ($user = ReliquiUsers::whereEmail(request('email'))->first()) {
            cache(['password.reset.'.$user->id => $token = Str::random()],
                now()->addMinutes(60)
            );

            Mail::to($user->email)->send(new ResetPasswordEmail(
                encrypt($user->id.'|'.$token)
            ));
        }

        return redirect()->route('reliqui.password.forgot')->with('passwordResetLinkSent', true);
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

            $user = ReliquiUsers::findOrFail($userId);
        } catch (Throwable $e) {
            return redirect()->route('reliqui.password.forgot')->with('invalidResetToken', true);
        }

        if (cache('password.reset.'.$userId) != $token) {
            return redirect()->route('reliqui.password.forgot')->with('invalidResetToken', true);
        }

        cache()->forget('password.reset.'.$userId);

        $user->password = Hash::make($password = Str::random());

        $user->save();

        return view('reliqui::auth.reset-password', [
            'password' => $password,
        ]);
    }
}
