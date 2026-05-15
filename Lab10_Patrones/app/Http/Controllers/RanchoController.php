<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Razas\Contracts\IRazaFactory;
use App\Domain\Razas\Exceptions\RazaNoSoportadaException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RanchoController extends Controller
{
    public function __construct(
        private readonly IRazaFactory $razaFactory,
    ) {}

    /**
     * Devuelve la ficha técnica de una raza para mostrarla al registrar un rancho.
     */
    public function fichaTecnicaRaza(Request $request): JsonResponse
    {
        $request->validate(['raza' => ['required', 'string']]);

        try {
            $raza = $this->razaFactory->create($request->string('raza')->toString());
        } catch (RazaNoSoportadaException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'nombre'              => $raza->getNombre(),
            'origen'              => $raza->getOrigenGeografico(),
            'peso_promedio_kg'    => $raza->getPesoPromedioAdulto(),
        ]);
    }
}
