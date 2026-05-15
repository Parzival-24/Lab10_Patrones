<?php

namespace App\Strategies;

// Modelo: Strategy
// Estrategia concreta que simula una llamada HTTP al servicio de YOLOv8 para estimar peso.
class AlgoritmoYoloV8 implements IAlgoritmoEstimacion
{
    public function ejecutar(array $datosEntrada): ResultadoEstimacion
    {
        if (!empty($datosEntrada['sin_conexion_yolov8'])) {
            throw new ServicioYoloNoDisponibleException('No hay conexion con el servicio YOLOv8.');
        }

        // Simulacion de inferencia remota basada en datos biometricos.
        $perimetroToracico = (float) ($datosEntrada['perimetro_toracico_cm'] ?? 160.0);
        $largoCorporal = (float) ($datosEntrada['largo_corporal_cm'] ?? 140.0);

        $pesoKg = (($perimetroToracico * $largoCorporal) / 10840) + 12.0;

        return new ResultadoEstimacion(
            round(max($pesoKg, 0.0), 2),
            92.0,
            'YOLOv8'
        );
    }
}
