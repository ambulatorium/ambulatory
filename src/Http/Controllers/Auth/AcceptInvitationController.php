<?php

namespace Reliqui\Ambulatory\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Invitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Reliqui\Ambulatory\Mail\CredentialEmail;

class AcceptInvitationController
{
    public function show($token)
    {
        $invitation = Invitation::whereToken($token)->firstOrFail();

        User::create([
            'id' => Str::uuid(),
            'name' => $invitation->email,
            'email' => $invitation->email,
            'password' => Hash::make($password = Str::random()),
            'type' => $invitation->findUserType(),
        ]);

        Mail::to($invitation->email)->send(new CredentialEmail($password));

        $invitation->delete();

        return redirect()->route('ambulatory.auth.login')->with('invitationAccepted', true);
    }
}
