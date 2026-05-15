<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Razas\Contracts\IRazaFactory;
use App\Domain\Razas\Factories\RazaFactory;
use Illuminate\Support\ServiceProvider;

class RazaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IRazaFactory::class, RazaFactory::class);
    }
}
