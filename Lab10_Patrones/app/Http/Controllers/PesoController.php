<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Razas\Contracts\IRazaFactory;
use App\Domain\Razas\Exceptions\RazaNoSoportadaException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PesoController extends Controller
{
    public function __construct(
        private readonly IRazaFactory $razaFactory,
    ) {}

    /**
     * Registra el peso de un bovino e incluye el peso promedio de su raza como referencia.
     */
    public function registrar(Request $request): JsonResponse
    {
        $request->validate([
            'raza'  => ['required', 'string'],
            'peso'  => ['required', 'numeric', 'min:1'],
            'fecha' => ['required', 'date'],
        ]);

        try {
            $raza = $this->razaFactory->create($request->string('raza')->toString());
        } catch (RazaNoSoportadaException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'raza'              => $raza->getNombre(),
            'peso_registrado'   => $request->float('peso'),
            'peso_promedio_ref' => $raza->getPesoPromedioAdulto(),
            'fecha'             => $request->input('fecha'),
        ], 201);
    }
}
