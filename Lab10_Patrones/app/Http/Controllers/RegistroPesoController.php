<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Pesos\RegistroPeso;
use App\Events\PesoRegistrado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Emisor del evento PesoRegistrado.
 *
 * ── ANTES del refactor (80+ líneas, responsabilidades mezcladas) ─────────────
 * public function store(Request $request): JsonResponse
 * {
 *     $request->validate([...]);
 *     $registro = RegistroPeso::create($request->validated());
 *
 *     // Llamadas directas a cada servicio — acoplamiento fuerte:
 *     $this->mailService->notificarPropietario($registro);       // ← dependencia 1
 *     $this->dashboardService->refrescarKPIs($registro->ranchoId); // ← dependencia 2
 *     $this->iccService->recalcular($registro->ranchoId);        // ← dependencia 3
 *     $this->senasaService->enviarWebhook($registro);            // ← dependencia 4
 *     // Agregar SMS requería modificar ESTE método → viola Open/Closed.
 *
 *     return response()->json($registro, 201);
 * }
 * ─────────────────────────────────────────────────────────────────────────────
 *
 * ── DESPUÉS (Patrón Observer via Laravel Events) ─────────────────────────────
 * El controlador solo conoce el evento; los observers son completamente
 * independientes. Agregar un nuevo observer = solo tocar EventServiceProvider.
 */
class RegistroPesoController extends Controller
{
    /**
     * Registra el peso de un bovino y notifica a todos los observers suscritos.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'pesoKg'           => ['required', 'numeric', 'min:0.1'],
            'razaNombre'       => ['required', 'string'],
            'propietarioEmail' => ['nullable', 'email'],
            'ranchoId'         => ['nullable', 'integer'],
            'fecha'            => ['required', 'date'],
        ]);

        $registro = new RegistroPeso(
            pesoKg:           (float) $data['pesoKg'],
            razaNombre:       $data['razaNombre'],
            propietarioEmail: $data['propietarioEmail'] ?? null,
            ranchoId:         isset($data['ranchoId']) ? (int) $data['ranchoId'] : null,
            fecha:            $data['fecha'],
        );

        // Una sola línea reemplaza todas las llamadas directas a servicios.
        // El EventDispatcher notifica a los 5 observers registrados.
        PesoRegistrado::dispatch($registro);

        return response()->json([
            'mensaje'   => 'Peso registrado correctamente.',
            'peso_kg'   => $registro->pesoKg,
            'raza'      => $registro->razaNombre,
            'fecha'     => $registro->fecha,
        ], 201);
    }
}
