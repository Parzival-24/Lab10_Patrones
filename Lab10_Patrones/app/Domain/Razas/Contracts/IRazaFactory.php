<?php

declare(strict_types=1);

namespace App\Domain\Razas\Contracts;

use App\Domain\Razas\Raza;
use App\Domain\Razas\Exceptions\RazaNoSoportadaException;

interface IRazaFactory
{
    /**
     * Crea e instancia la raza correspondiente al nombre dado.
     *
     * La comparación es case-insensitive y tolera espacios al inicio/fin.
     *
     * @param  string $nombreRaza  Nombre de la raza (ej. "Brahman", "nelore").
     * @return Raza                Instancia concreta de la raza solicitada.
     *
     * @throws RazaNoSoportadaException Si el nombre no corresponde a ninguna raza registrada.
     */
    public function create(string $nombreRaza): Raza;
}
