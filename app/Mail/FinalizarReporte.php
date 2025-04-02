<?php

namespace App\Mail;

use App\Models\Reporte;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinalizarReporte extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reporte;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reporte $reporte, User $user)
    {
        $this->reporte = $reporte;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.finalizar_reporte')
                    ->attach(public_path('images/Icons/logo.png'), [
                        'as' => 'logo.png',
                        'mime' => 'image/png',
                    ])
                    ->with([
                        'reporte' => $this->reporte,
                        'user' => $this->user
                    ]);
    }

}
