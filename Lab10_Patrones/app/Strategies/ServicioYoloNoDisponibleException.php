<?php

namespace App\Strategies;

use RuntimeException;

// Modelo: Strategy
// Excepcion para representar falta de conexion con el servicio externo de YOLOv8.
// Representar explícitamente caída/no conexión de YOLOv8 y activar fallback en el contexto.
class ServicioYoloNoDisponibleException extends RuntimeException
{
}
