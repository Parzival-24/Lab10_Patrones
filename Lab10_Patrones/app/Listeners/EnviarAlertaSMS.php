<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PesoRegistrado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/**
 * ConcreteObserver encolado: envía SMS al propietario.
 *
 * EXTENSIBILIDAD (Patrón Observer):
 * Este listener fue agregado DESPUÉS de que el controlador, el evento y los
 * demás listeners ya existían. La única modificación necesaria fue registrarlo
 * en EventServiceProvider::$listen. Ni el controlador ni los otros observers
 * fueron tocados — esto es la esencia del principio Open/Closed.
 */
class EnviarAlertaSMS implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct() {}

    public function handle(PesoRegistrado $evento): void
    {
        $registro = $evento->registroPeso;

        Log::info('EnviarAlertaSMS: enviando alerta', [
            'destinatario' => $registro->propietarioEmail,
            'peso_kg'      => $registro->pesoKg,
        ]);

        // Aquí iría la integración real (Twilio, AWS SNS, etc.)
    }

    public function failed(PesoRegistrado $evento, \Throwable $exception): void
    {
        Log::error('EnviarAlertaSMS: falló definitivamente', [
            'error' => $exception->getMessage(),
        ]);
    }
}
