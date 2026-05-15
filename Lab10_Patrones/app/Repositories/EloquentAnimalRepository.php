<?php

namespace App\Repositories;

use App\Models\Animal;

// Modelo: Repository
// Implementación concreta de IAnimalRepository usando Eloquent ORM para acceder a la base de datos.
class EloquentAnimalRepository implements IAnimalRepository
{
    public function findByArete(string $arete): ?Animal
    {
        return Animal::where('arete', $arete)->first();
    }

    public function findAllByRancho(int $ranchoId): array
    {
        return Animal::where('rancho_id', $ranchoId)->get()->all();
    }

    public function save(Animal $animal): void
    {
        $animal->save();
    }

    public function delete(int $id): void
    {
        Animal::destroy($id);
    }
}
