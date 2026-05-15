<?php

namespace App\Strategies;

// Modelo: Strategy
// Estrategia concreta que estima el peso usando una tabla de referencia por edad.
class AlgoritmoTablaReferencia implements IAlgoritmoEstimacion
{
    public function ejecutar(array $datosEntrada): ResultadoEstimacion
    {
        $edadMeses = (int) ($datosEntrada['edad_meses'] ?? 12);

        $tabla = [
            6 => 120.0,
            12 => 220.0,
            18 => 310.0,
            24 => 390.0,
            30 => 460.0,
        ];

        $pesoKg = $this->buscarPesoPorEdad($edadMeses, $tabla);

        return new ResultadoEstimacion(
            $pesoKg,
            72.0,
            'TablaReferencia'
        );
    }

    private function buscarPesoPorEdad(int $edadMeses, array $tabla): float
    {
        ksort($tabla);

        foreach ($tabla as $edadReferencia => $pesoReferencia) {
            if ($edadMeses <= $edadReferencia) {
                return $pesoReferencia;
            }
        }

        return (float) end($tabla);
    }
}
