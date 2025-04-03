<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plainPassword;

    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Confirmación de cuenta y datos de acceso')
                    ->markdown('emails.user_created')
                    ->attach(public_path('images/Icons/logo.png'), [
                        'as' => 'logo.png',
                        'mime' => 'image/png',
                    ]);
    }

}
