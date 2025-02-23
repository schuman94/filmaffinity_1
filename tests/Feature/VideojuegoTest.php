<?php

use App\Models\User;
use App\Models\Desarrollador;
use App\Models\Videojuego;
use Carbon\Carbon;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('El usuario crea un videojuego', function () {
    $usuario = User::factory()->create();
    $desarrollador = Desarrollador::factory()->create();
    $fecha = "12-12-2012";

    $response = $this
        ->actingAs($usuario)
        ->from('/videojuegos/create')
        ->post('/videojuegos', [
            'titulo' => 'videojuego de prueba',
            'desarrollador_id' => $desarrollador->id,
            'fecha_lanzamiento' => $fecha,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/videojuegos/1');

    $this->assertAuthenticated();
    $this->assertDatabaseHas('videojuegos', [
        'id' => 1,
        'titulo' => 'videojuego de prueba',
        'desarrollador_id' => $desarrollador->id,
        'fecha_lanzamiento' => Carbon::createFromFormat('d-m-Y', $fecha)->utc()
    ]);
});

test('El usuario elimina un videojuego (softdelete) y luego lo restaura', function() {
    $usuario = User::factory()->create();
    $desarrollador = Desarrollador::factory()->create();
    $videojuego = Videojuego::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->from('/videojuegos')
        ->delete('/videojuegos/' . $videojuego->id);

    $response
    ->assertSessionHasNoErrors()
    ->assertRedirect('/videojuegos');

    $this->assertSoftDeleted('videojuegos', [
        'id' => $videojuego->id,
    ]);

    $response = $this
        ->actingAs($usuario)
        ->from('/videojuegos_eliminados')
        ->post('/videojuegos/restaurar/' . $videojuego->id);

    $response
    ->assertSessionHasNoErrors()
    ->assertRedirect('/videojuegos/' . $videojuego->id);

    $this->assertDatabaseHas('videojuegos', [
        'id' => $videojuego->id,
        'deleted_at' => null
    ]);
});

test('El usuario valora un videojuego', function() {
    $usuario = User::factory()->create();
    $desarrollador = Desarrollador::factory()->create();
    $videojuego = Videojuego::factory()->create();

    $puntuacion = '9';
    $comentario = 'comentario de prueba';

    $response = $this
        ->actingAs($usuario)
        ->from('/videojuegos/' . $videojuego->id)
        ->put('/videojuegos/' . $videojuego->id . '/valorar', [
            'puntuacion' => $puntuacion,
            'comentario' => $comentario,
        ]);

    $response
    ->assertSessionHasNoErrors()
    ->assertRedirect('/valoraciones/1');

    $this->assertDatabaseHas('valoraciones', [
        'puntuacion' => $puntuacion,
        'comentario' => $comentario
    ]);
});

test('El usuario filtra un ranking de videojuegos por desarrollador', function() {
    $usuario = User::factory()->create();

    $desarrollador1 = Desarrollador::factory()->create();
    $desarrollador2 = Desarrollador::factory()->create();

    $videojuego1 = Videojuego::factory()->create([
        'titulo' => 'Juego1',
        'desarrollador_id' => $desarrollador1->id,
    ]);
    $videojuego2 = Videojuego::factory()->create([
        'titulo' => 'Juego2',
        'desarrollador_id' => $desarrollador2->id
    ]);

    $response = $this
        ->actingAs($usuario)
        ->get(route('videojuegos.ranking', [
            'titulo' => $videojuego1->titulo,
            'desarrollador' => $desarrollador1->nombre
        ]));

    $response
    ->assertSessionHasNoErrors()
    ->assertStatus(200)
    ->assertSee($videojuego1->titulo)
    ->assertDontSee($videojuego2->titulo);
});
