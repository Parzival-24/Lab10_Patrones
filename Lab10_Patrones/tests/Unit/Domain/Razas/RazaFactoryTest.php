<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Razas;

use App\Domain\Razas\Brahman;
use App\Domain\Razas\Exceptions\RazaNoSoportadaException;
use App\Domain\Razas\Factories\RazaFactory;
use App\Domain\Razas\Nelore;
use PHPUnit\Framework\TestCase;

class RazaFactoryTest extends TestCase
{
    private RazaFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new RazaFactory();
    }

    public function test_crea_instancia_de_brahman_correctamente(): void
    {
        $raza = $this->factory->create('brahman');

        $this->assertInstanceOf(Brahman::class, $raza);
        $this->assertSame('Brahman', $raza->getNombre());
    }

    public function test_crea_instancia_de_nelore_correctamente(): void
    {
        $raza = $this->factory->create('nelore');

        $this->assertInstanceOf(Nelore::class, $raza);
        $this->assertSame('Nelore', $raza->getNombre());
    }

    public function test_es_case_insensitive(): void
    {
        $this->assertInstanceOf(Brahman::class, $this->factory->create('BRAHMAN'));
        $this->assertInstanceOf(Brahman::class, $this->factory->create('brahman'));
        $this->assertInstanceOf(Brahman::class, $this->factory->create('Brahman'));
        $this->assertInstanceOf(Brahman::class, $this->factory->create('  Brahman  '));
    }

    public function test_lanza_excepcion_si_raza_no_existe(): void
    {
        $this->expectException(RazaNoSoportadaException::class);

        $this->factory->create('Angus');
    }

    public function test_excepcion_lista_las_razas_disponibles(): void
    {
        try {
            $this->factory->create('Charolais');
            $this->fail('Se esperaba RazaNoSoportadaException');
        } catch (RazaNoSoportadaException $e) {
            $this->assertStringContainsString('brahman', $e->getMessage());
            $this->assertStringContainsString('nelore', $e->getMessage());
            $this->assertStringContainsString('Charolais', $e->getMessage());
        }
    }
}
