<?php

namespace Reliqui\Ambulatory\Mail;

use Illuminate\Mail\Mailable;
use Reliqui\Ambulatory\ReliquiInvitation;

class InvitationEmail extends Mailable
{
    /**
     * @var \Reliqui\Ambulatory\ReliquiInvitation
     */
    public $invitation;

    /**
     * New instance.
     *
     * @param string $inviation
     * @return void
     */
    public function __construct(ReliquiInvitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').': Invitation')
            ->view('reliqui::emails.invitation', [
                'link'  => route('reliqui.accept.invitation.show', ['token' => $this->invitation->token]),
                'role'  => $this->invitation->role,
            ]);
    }
}
