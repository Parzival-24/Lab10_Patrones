<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PesoRegistrado;
use App\Mail\NotificacionPesoMail;
use Illuminate\Support\Facades\Mail;

/**
 * ConcreteObserver: envía un email al propietario del animal.
 * No se encola porque el mailer de Laravel ya lo gestiona internamente.
 */
class NotificarPropietario
{
    public function __construct() {}

    public function handle(PesoRegistrado $evento): void
    {
        if ($evento->registroPeso->propietarioEmail === null) {
            return;
        }

        Mail::to($evento->registroPeso->propietarioEmail)
            ->send(new NotificacionPesoMail($evento->registroPeso));
    }
}
