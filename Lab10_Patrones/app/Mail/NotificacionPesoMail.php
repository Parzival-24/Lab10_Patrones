<?php

declare(strict_types=1);

namespace App\Mail;

use App\Domain\Pesos\RegistroPeso;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionPesoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly RegistroPeso $registroPeso) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'BovWeight CR – Nuevo peso registrado: ' . $this->registroPeso->pesoKg . ' kg',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion-peso',
        );
    }
}
