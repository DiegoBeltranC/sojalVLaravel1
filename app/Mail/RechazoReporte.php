<?php

namespace App\Mail;

use App\Models\Reporte;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RechazoReporte extends Mailable
{
    use Queueable, SerializesModels;

    public $motivo;
    public $reporte;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($motivo, Reporte $reporte)
    {
        $this->motivo = $motivo;
        $this->reporte = $reporte;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.rechazo_reporte')
                    ->attach(public_path('images/Icons/logo.png'), [
                        'as' => 'logo.png',
                        'mime' => 'image/png',
                    ])
                    ->with([
                        'reporte' => $this->reporte,
                        'motivo' => $this->motivo
                    ]);
    }

}
