<?php

namespace App\Mail;

use App\Models\FirmaToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudFirmaProgramaMail extends Mailable
{
    use Queueable, SerializesModels;

    public FirmaToken $token;

    public function __construct(FirmaToken $token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('VB° Programa – Ficha de Prácticas')
            ->view('emails.firma-programa');
    }
}
