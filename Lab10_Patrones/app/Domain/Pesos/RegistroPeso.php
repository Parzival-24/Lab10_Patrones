<?php

declare(strict_types=1);

namespace App\Domain\Pesos;

/**
 * DTO inmutable que representa el registro de un peso bovino.
 * No extiende Eloquent: es un objeto de dominio puro, sin acoplamiento a la BD.
 */
final class RegistroPeso
{
    public function __construct(
        public readonly float   $pesoKg,
        public readonly string  $razaNombre,
        public readonly ?string $propietarioEmail = null,
        public readonly ?int    $ranchoId = null,
        public readonly string  $fecha = '',
    ) {}
}
