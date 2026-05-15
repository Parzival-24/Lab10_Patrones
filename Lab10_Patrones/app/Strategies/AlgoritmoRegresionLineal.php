<?php

namespace App\Strategies;

// Modelo: Strategy
// Estrategia concreta que estima el peso mediante una formula simplificada de regresion lineal.
class AlgoritmoRegresionLineal implements IAlgoritmoEstimacion
{
    public function ejecutar(array $datosEntrada): ResultadoEstimacion
    {
        $edadMeses = (float) ($datosEntrada['edad_meses'] ?? 12.0);
        $perimetroToracico = (float) ($datosEntrada['perimetro_toracico_cm'] ?? 160.0);

        $pesoKg = (1.85 * $edadMeses) + (0.92 * $perimetroToracico) - 35.0;

        return new ResultadoEstimacion(
            round(max($pesoKg, 0.0), 2),
            84.0,
            'RegresionLineal'
        );
    }
}
