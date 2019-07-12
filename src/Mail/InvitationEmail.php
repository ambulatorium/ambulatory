<?php

namespace Ambulatory\Mail;

use Illuminate\Mail\Mailable;
Use Ambulatory\Invitation;

class InvitationEmail extends Mailable
{
    /**
     * @var \Ambulatory\Ambulatory\Invitation
     */
    public $invitation;

    /**
     * New instance.
     *
     * @param string $invitation
     * @return void
     */
    public function __construct(Invitation $invitation)
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
            ->view('ambulatory::emails.invitation', [
                'link'  => route('ambulatory.accept.invitation', ['token' => $this->invitation->token]),
                'role'  => $this->invitation->role,
            ]);
    }
}
