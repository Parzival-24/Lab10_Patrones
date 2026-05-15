<?php

declare(strict_types=1);

namespace App\Domain\Razas;

abstract class Raza
{
    /**
     * Nombre identificador de la raza.
     */
    abstract public function getNombre(): string;

    /**
     * País o región de origen de la raza.
     */
    abstract public function getOrigenGeografico(): string;

    /**
     * Peso promedio de un adulto de esta raza en kilogramos.
     */
    abstract public function getPesoPromedioAdulto(): float;
}
