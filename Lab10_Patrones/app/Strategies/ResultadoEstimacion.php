<?php

namespace App\Strategies;

// Modelo: Strategy
// Value Object inmutable (sin setters) que encapsula el resultado de una estimacion.
// Transportar resultado con formato consistente.

final class ResultadoEstimacion
{
    public function __construct(
        public readonly float $pesoKg,
        public readonly float $confianzaPorcentaje,
        public readonly string $metodoUsado
    ) {
    }
}
