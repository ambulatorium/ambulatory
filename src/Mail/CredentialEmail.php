<?php

namespace Ambulatory\Ambulatory\Mail;

use Illuminate\Mail\Mailable;

class CredentialEmail extends Mailable
{
    /**
     * @var string
     */
    public $password;

    /**
     * New instance.
     *
     * @param string $password
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' [credential]')
            ->view('ambulatory::emails.credential', [
                'password' => $this->password,
            ]);
    }
}
