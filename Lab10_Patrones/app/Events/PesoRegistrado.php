<?php

declare(strict_types=1);

namespace App\Events;

use App\Domain\Pesos\RegistroPeso;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Evento de dominio: se despacha cada vez que se registra el peso de un bovino.
 *
 * Mapeo GoF → Laravel:
 *   - Subject (notificar)  → Event::dispatch() / el EventDispatcher del framework
 *   - ConcreteSubject data → esta clase (DTO inmutable, sin lógica de negocio)
 *
 * SerializesModels permite que los listeners encolados (ShouldQueue) serialicen
 * el payload correctamente. Aunque RegistroPeso no es Eloquent, PHP serializa
 * objetos planos sin problemas.
 */
final class PesoRegistrado
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly RegistroPeso $registroPeso) {}
}
