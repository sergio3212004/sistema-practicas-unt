<?php

namespace App\Mail;

use App\Models\FirmaTokenCronograma;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FirmaCronogramaJefeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FirmaTokenCronograma $firmaToken
    ) {}

    public function build()
    {
        return $this
            ->subject('Firma de Cronograma de Prácticas')
            ->view('emails.firma-cronograma-jefe');
    }
}
