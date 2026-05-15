<?php

namespace App\Repositories;

use App\Models\Animal;

// Modelo: Repository
// Implementación de IAnimalRepository que almacena los datos en memoria, útil para pruebas sin base de datos.
// Implementación en memoria con array privado.
class InMemoryAnimalRepository implements IAnimalRepository
{
    private array $animals = [];

    public function findByArete(string $arete): ?Animal
    {
        foreach ($this->animals as $animal) {
            if ($animal->arete === $arete) {
                return $animal;
            }
        }
        return null;
    }

    public function findAllByRancho(int $ranchoId): array
    {
        return array_filter($this->animals, function ($animal) use ($ranchoId) {
            return $animal->rancho_id === $ranchoId;
        });
    }

    public function save(Animal $animal): void
    {
        $this->animals[$animal->id] = $animal;
    }

    public function delete(int $id): void
    {
        unset($this->animals[$id]);
    }
}
