<?php

namespace Ambulatory\Ambulatory\Http\Controllers\Auth;

use Ambulatory\Ambulatory\Invitation;

class AcceptInvitationController
{
    /**
     * Accept invitation with a valid token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        tap(Invitation::whereToken($token)->firstOrFail(), function ($invitation) {
            $invitation->accepted();

            $invitation->delete();
        });

        return redirect()->route('ambulatory.login')->with('invitationAccepted', true);
    }
}
