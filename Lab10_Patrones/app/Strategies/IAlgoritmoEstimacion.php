<?php

namespace App\Strategies;

// Modelo: Strategy
// Interfaz comun para todos los algoritmos de estimacion de peso.
// Cualquier algoritmo debe implementar el mismo método.

interface IAlgoritmoEstimacion
{
    public function ejecutar(array $datosEntrada): ResultadoEstimacion;
}
