<?php

declare(strict_types=1);

namespace App\Domain\Razas\Factories;

use App\Domain\Razas\Brahman;
use App\Domain\Razas\Contracts\IRazaFactory;
use App\Domain\Razas\Exceptions\RazaNoSoportadaException;
use App\Domain\Razas\Nelore;
use App\Domain\Razas\Raza;

class RazaFactory implements IRazaFactory
{
    /** @var array<string, class-string<Raza>> */
    private array $mapaRazas = [
        'brahman' => Brahman::class,
        'nelore'  => Nelore::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function create(string $nombreRaza): Raza
    {
        $clave = strtolower(trim($nombreRaza));

        if (!array_key_exists($clave, $this->mapaRazas)) {
            throw new RazaNoSoportadaException($nombreRaza, array_keys($this->mapaRazas));
        }

        $clase = $this->mapaRazas[$clave];

        return new $clase();
    }
}
