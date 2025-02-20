<?php

use App\Models\User;
use App\Models\Desarrollador;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});



test('El usuario crea un videojuego', function () {
    $usuario = User::factory()->create();
    $desarrollador = Desarrollador::factory()->create();

    $fecha = now();

    $response = $this
        ->actingAs($usuario)
        ->from('/videojuegos/create')
        ->post('/videojuegos', [
            'titulo' => 'videojuego de prueba',
            'desarrollador_id' => $desarrollador->id,
            'fecha_lanzamiento' => $fecha,
        ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('videojuegos', [
        'titulo' => 'videojuego de prueba',
        'desarrollador_id' => $desarrollador->id,
        'fecha_lanzamiento' => $fecha->format('Y-m-d\TH:i:s.u\Z'),
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/videojuegos/1');
});



