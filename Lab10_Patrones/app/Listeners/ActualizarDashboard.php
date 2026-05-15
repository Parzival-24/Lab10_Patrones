<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PesoRegistrado;
use Illuminate\Support\Facades\Cache;

/**
 * ConcreteObserver: invalida la caché del dashboard del rancho para que
 * los KPIs se recalculen en la próxima solicitud.
 */
class ActualizarDashboard
{
    public function __construct() {}

    public function handle(PesoRegistrado $evento): void
    {
        Cache::forget("dashboard.rancho.{$evento->registroPeso->ranchoId}");
        Cache::forget('dashboard.global.kpis');
    }
}
