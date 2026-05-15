<?php

declare(strict_types=1);

namespace App\Domain\Razas\Exceptions;

use InvalidArgumentException;

class RazaNoSoportadaException extends InvalidArgumentException
{
    /**
     * @param string   $nombreRaza  Raza solicitada que no existe en el mapa.
     * @param string[] $disponibles Lista de claves normalizadas soportadas.
     */
    public function __construct(string $nombreRaza, array $disponibles)
    {
        $lista = implode(', ', $disponibles);

        parent::__construct(
            "La raza \"{$nombreRaza}\" no está soportada. Razas disponibles: {$lista}."
        );
    }
}
