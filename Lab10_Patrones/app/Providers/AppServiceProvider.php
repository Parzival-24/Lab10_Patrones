<?php

namespace App\Providers;

use App\Repositories\EloquentAnimalRepository;
use App\Repositories\IAnimalRepository;
use App\Services\EstimadorPesoService;
use App\Strategies\AlgoritmoTablaReferencia;
use App\Strategies\AlgoritmoYoloV8;
use App\Strategies\IAlgoritmoEstimacion;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAnimalRepository::class, EloquentAnimalRepository::class);
        $this->app->bind(IAlgoritmoEstimacion::class, AlgoritmoYoloV8::class);

        $this->app->bind(EstimadorPesoService::class, function ($app) {
            return new EstimadorPesoService(
                $app->make(AlgoritmoYoloV8::class),
                $app->make(AlgoritmoTablaReferencia::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ...existing code...
    }
}