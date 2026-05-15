<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PesoRegistrado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * ConcreteObserver encolado: notifica a SENASA vía HTTP POST.
 * Se encola porque las llamadas HTTP externas tienen latencia variable.
 */
class WebhookSenasa implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct() {}

    public function handle(PesoRegistrado $evento): void
    {
        $registro = $evento->registroPeso;

        Http::post((string) config('services.senasa.webhook_url'), [
            'peso_kg'   => $registro->pesoKg,
            'raza'      => $registro->razaNombre,
            'fecha'     => $registro->fecha,
            'rancho_id' => $registro->ranchoId,
        ]);
    }

    public function failed(PesoRegistrado $evento, \Throwable $exception): void
    {
        Log::error('WebhookSenasa: falló definitivamente', [
            'peso_kg' => $evento->registroPeso->pesoKg,
            'error'   => $exception->getMessage(),
        ]);
    }
}
