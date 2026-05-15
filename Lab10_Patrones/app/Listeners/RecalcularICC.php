<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PesoRegistrado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

/**
 * ConcreteObserver encolado: recalcula el Índice de Condición Corporal (ICC)
 * del rancho. Se encola porque el cálculo puede ser costoso.
 */
class RecalcularICC implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct() {}

    public function handle(PesoRegistrado $evento): void
    {
        Log::info('RecalcularICC: iniciando recálculo', [
            'rancho_id' => $evento->registroPeso->ranchoId,
            'peso_kg'   => $evento->registroPeso->pesoKg,
        ]);

        // Aquí iría la lógica real: ICC = (peso_actual / peso_ideal_raza) * 100
        // y la persistencia del resultado en la tabla icc_rancho.
    }

    public function failed(PesoRegistrado $evento, \Throwable $exception): void
    {
        Log::error('RecalcularICC: falló definitivamente', [
            'rancho_id' => $evento->registroPeso->ranchoId,
            'error'     => $exception->getMessage(),
        ]);
    }
}
