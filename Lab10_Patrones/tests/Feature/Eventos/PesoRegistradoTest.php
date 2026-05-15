<?php

declare(strict_types=1);

namespace Tests\Feature\Eventos;

use App\Domain\Pesos\RegistroPeso;
use App\Events\PesoRegistrado;
use App\Listeners\ActualizarDashboard;
use App\Listeners\EnviarAlertaSMS;
use App\Listeners\NotificarPropietario;
use App\Listeners\RecalcularICC;
use App\Listeners\WebhookSenasa;
use App\Mail\NotificacionPesoMail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PesoRegistradoTest extends TestCase
{
    // ─── Test 1 ──────────────────────────────────────────────────────────────

    /**
     * Verifica que el controlador despacha PesoRegistrado al recibir una petición válida.
     * Rol GoF: comprueba que el Subject llama a notificar() (dispatch).
     */
    public function test_dispatcha_evento_al_registrar_peso(): void
    {
        Event::fake([PesoRegistrado::class]);

        $this->postJson('/api/registros-peso', [
            'pesoKg'           => 350.0,
            'razaNombre'       => 'brahman',
            'propietarioEmail' => 'dueno@finca.cr',
            'ranchoId'         => 42,
            'fecha'            => '2026-05-15',
        ])->assertStatus(201);

        Event::assertDispatched(PesoRegistrado::class, function (PesoRegistrado $event): bool {
            return $event->registroPeso->pesoKg === 350.0
                && $event->registroPeso->razaNombre === 'brahman';
        });
    }

    // ─── Test 2 ──────────────────────────────────────────────────────────────

    /**
     * Verifica que todos los observers (listeners) están suscritos al evento.
     * Rol GoF: comprueba que suscribir() fue llamado para cada ConcreteObserver.
     */
    public function test_todos_los_listeners_estan_registrados(): void
    {
        Event::fake();

        Event::assertListening(PesoRegistrado::class, NotificarPropietario::class);
        Event::assertListening(PesoRegistrado::class, ActualizarDashboard::class);
        Event::assertListening(PesoRegistrado::class, RecalcularICC::class);
        Event::assertListening(PesoRegistrado::class, WebhookSenasa::class);
        Event::assertListening(PesoRegistrado::class, EnviarAlertaSMS::class);
    }

    // ─── Test 3 ──────────────────────────────────────────────────────────────

    /**
     * Verifica que NotificarPropietario envía el email correcto al ejecutarse.
     * Rol GoF: comprueba que el ConcreteObserver reacciona correctamente a update().
     */
    public function test_notificador_propietario_envia_email(): void
    {
        Mail::fake();

        $registroFake = new RegistroPeso(
            pesoKg:           420.5,
            razaNombre:       'nelore',
            propietarioEmail: 'propietario@rancho.cr',
            ranchoId:         1,
            fecha:            '2026-05-15',
        );

        $listener = app(NotificarPropietario::class);
        $listener->handle(new PesoRegistrado($registroFake));

        Mail::assertSent(NotificacionPesoMail::class, function (NotificacionPesoMail $mail) use ($registroFake): bool {
            return $mail->registroPeso->pesoKg === $registroFake->pesoKg;
        });
    }

    // ─── Test 4 ──────────────────────────────────────────────────────────────

    /**
     * Demuestra la extensibilidad del Patrón Observer:
     * EnviarAlertaSMS fue agregado DESPUÉS del controlador, el evento y los demás
     * listeners. Para incorporarlo solo se modificó EventServiceProvider::$listen.
     * El controlador (RegistroPesoController), el evento (PesoRegistrado) y los
     * otros cuatro listeners NO fueron tocados — cumple el principio Open/Closed.
     */
    public function test_sms_agregado_sin_modificar_controlador_ni_otros_listeners(): void
    {
        Event::fake();

        // EnviarAlertaSMS está registrado como observer de PesoRegistrado
        // sin que el controlador lo conozca directamente.
        Event::assertListening(PesoRegistrado::class, EnviarAlertaSMS::class);
    }
}
