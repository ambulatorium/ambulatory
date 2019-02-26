<?php

namespace Reliqui\Ambulatory\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Reliqui\Ambulatory\ReliquiUsers;
use Illuminate\Support\Facades\Mail;
use Reliqui\Ambulatory\ReliquiInvitation;
use Reliqui\Ambulatory\Mail\CredentialEmail;

class AcceptInvitationController
{
    public function show($token)
    {
        $invitation = ReliquiInvitation::whereToken($token)->firstOrFail();

        ReliquiUsers::create([
            'id'       => Str::uuid(),
            'name'     => $invitation->email,
            'email'    => $invitation->email,
            'password' => Hash::make($password = Str::random()),
            'type'     => $invitation->findUserType(),
        ]);

        Mail::to($invitation->email)->send(new CredentialEmail($password));

        $invitation->delete();

        return redirect()->route('reliqui.auth.login')->with('invitationAccepted', true);
    }
}
