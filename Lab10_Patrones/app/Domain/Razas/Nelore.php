<?php

declare(strict_types=1);

namespace App\Domain\Razas;

class Nelore extends Raza
{
    public function getNombre(): string
    {
        return 'Nelore';
    }

    public function getOrigenGeografico(): string
    {
        return 'India (raza Ongole)';
    }

    public function getPesoPromedioAdulto(): float
    {
        return 620.0;
    }
}
