<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\PesoRegistrado;
use App\Listeners\ActualizarDashboard;
use App\Listeners\EnviarAlertaSMS;
use App\Listeners\NotificarPropietario;
use App\Listeners\RecalcularICC;
use App\Listeners\WebhookSenasa;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Registro explícito de eventos y listeners (Patrón Observer – GoF).
 *
 * Mapeo conceptual:
 *   $listen  ≡  suscribir(observer)  del GoF Subject
 *   clave    →  ConcreteSubject (el evento)
 *   valores  →  ConcreteObservers (los listeners)
 *
 * DECISIÓN DE DISEÑO – registro manual vs. event discovery:
 * Laravel 12 tiene event discovery habilitado por defecto: escanea app/Listeners/
 * e infiere el evento por el tipo del parámetro de handle().
 * Para este laboratorio se usa registro EXPLÍCITO porque:
 *   1) Centraliza el mapeo Subject→Observer en un solo archivo visible.
 *   2) Facilita auditoría: se ve de un vistazo qué observers reaccionan a cada evento.
 *   3) Equivale directamente al rol de "registro de suscriptores" del GoF.
 *   4) Evita que el discovery genere sorpresas al agregar listeners en el futuro.
 */
class EventServiceProvider extends ServiceProvider
{
    /** @var array<class-string, list<class-string>> */
    protected $listen = [
        PesoRegistrado::class => [
            NotificarPropietario::class,
            ActualizarDashboard::class,
            RecalcularICC::class,
            WebhookSenasa::class,
            EnviarAlertaSMS::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }

    /** Deshabilitamos el discovery automático para usar el registro explícito. */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
