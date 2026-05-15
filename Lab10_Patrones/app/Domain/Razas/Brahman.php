<?php

declare(strict_types=1);

namespace App\Domain\Razas;

class Brahman extends Raza
{
    public function getNombre(): string
    {
        return 'Brahman';
    }

    public function getOrigenGeografico(): string
    {
        return 'India / Sur de Asia';
    }

    public function getPesoPromedioAdulto(): float
    {
        return 680.0;
    }
}
