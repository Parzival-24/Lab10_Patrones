<?php

namespace App\Repositories;

use App\Models\Animal;

// Modelo: Repository
// Interfaz para definir el contrato de acceso a datos de Animal, sin exponer detalles del ORM.
// Define operaciones del dominio sin depender de Eloquent.
interface IAnimalRepository
{
    public function findByArete(string $arete): ?Animal;
    public function findAllByRancho(int $ranchoId): array;
    public function save(Animal $animal): void;
    public function delete(int $id): void;
}
