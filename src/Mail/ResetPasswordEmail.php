<?php

namespace Reliqui\Ambulatory\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordEmail extends Mailable
{
    /**
     * The token for the reset.
     *
     * @var string
     */
    public $token;

    /**
     * New instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').': Reset Password Notification')
            ->view('reliqui::emails.forgot-password', [
                'link' => route('reliqui.password.reset', ['token' => $this->token]),
            ]);
    }
}
