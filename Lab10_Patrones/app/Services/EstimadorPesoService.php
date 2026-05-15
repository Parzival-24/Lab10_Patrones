<?php

namespace App\Services;

use App\Strategies\IAlgoritmoEstimacion;
use App\Strategies\ResultadoEstimacion;
use App\Strategies\ServicioYoloNoDisponibleException;

// Modelo: Strategy
// Contexto que ejecuta un algoritmo de estimacion por interfaz y aplica fallback si YOLOv8 no esta disponible.
// Orquesta ejecución de algoritmo sin conocer implementación concreta.

class EstimadorPesoService
{
    private IAlgoritmoEstimacion $algoritmo;

    private ?IAlgoritmoEstimacion $algoritmoFallback;

    public function __construct(IAlgoritmoEstimacion $algoritmo, ?IAlgoritmoEstimacion $algoritmoFallback = null)
    {
        $this->algoritmo = $algoritmo;
        $this->algoritmoFallback = $algoritmoFallback;
    }

    public function cambiarAlgoritmo(IAlgoritmoEstimacion $algoritmo): void
    {
        $this->algoritmo = $algoritmo;
    }

    public function definirFallback(IAlgoritmoEstimacion $algoritmoFallback): void
    {
        $this->algoritmoFallback = $algoritmoFallback;
    }

    public function estimar(array $datosEntrada): ResultadoEstimacion
    {
        try {
            return $this->algoritmo->ejecutar($datosEntrada);
        } catch (ServicioYoloNoDisponibleException $exception) {
            if ($this->algoritmoFallback === null) {
                throw $exception;
            }

            return $this->algoritmoFallback->ejecutar($datosEntrada);
        }
    }
}
