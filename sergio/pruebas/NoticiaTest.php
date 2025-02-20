<?php

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('la página principal funciona', function () {
    $response = $this->get('/');  // En la variable response se recoge la respuesta producida por la peticion.

    $response->assertStatus(200);
});

test('logueado se puede crear una noticia', function () {
    $usuario = User::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->get('/noticias/create');

    $response->assertOk();  // Esto es exactamente lo mismo que assertStatus(200)
});

test('como invitado no se puede crear una noticia', function () {
    $response = $this->get('/noticias/create');

    $response->assertRedirect('/login'); //Con esto podemos comprobar si obtenemos una redireccion concreta
});

test('el usuario crea una noticia', function () {
    $usuario = User::factory()->create();
    $categoria = Categoria::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->from('/noticias/create')  // Indicamos desde la ruta en la que partimos
        ->post('/noticias', [   // Indicamos la ruta a la que hacemos la peticion (importante el verbo, post, get, delete...)
            'titular' => 'titular de prueba',  // El array que lleva la request con los datos del formulario
            'descripcion' => 'descripción de prueba',
            'url' => 'url de prueba',
            'categoria_id' => $categoria->id,
            'user_id' => $usuario->id,
        ]);

    $this->assertAuthenticated();  // Aqui no se hace un assert a la response, sino al $this (al test) para comprobar que está autenticado (Esto lo hemos puesto porque está bien ponerlo)
    $this->assertDatabaseHas('noticias', [   // Aqui se hace una comprobación de que la tabla noticias, tiene una fila con los siguientes valores.
        'titular' => 'titular de prueba',    // assertDatabaseMissing es para comprobar que no se ha creado. Hay mas en: https://laravel.com/docs/11.x/database-testing#available-assertions
        'descripcion' => 'descripción de prueba',
        'url' => 'url de prueba',
        'categoria_id' => $categoria->id,
        'user_id' => $usuario->id,
    ]);

    $response
        ->assertSessionHasNoErrors()  // Esto comprueba que no hay errores en la sesion. Se trata de los errores que se produce cuando hacemos el validate y falla algun campo.
        ->assertRedirect('/');  // Se pueden encadenar asserts
});

test('el usuario crea una noticia con imagen', function () {
    $usuario = User::factory()->create();
    $categoria = Categoria::factory()->create();
    Storage::fake('public');

    $archivo = UploadedFile::fake()->image('prueba.jpg');

    $response = $this
        ->actingAs($usuario)
        ->from('/noticias/create')
        ->post('/noticias', [
            'titular' => 'titular de prueba',
            'descripcion' => 'descripción de prueba',
            'url' => 'url de prueba',
            'categoria_id' => $categoria->id,
            'user_id' => $usuario->id,
            'imagen' => $archivo,
        ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('noticias', [
        'id' => 2,
        'titular' => 'titular de prueba',
        'descripcion' => 'descripción de prueba',
        'url' => 'url de prueba',
        'categoria_id' => $categoria->id,
        'user_id' => $usuario->id,
    ]);

    Storage::disk('public')->assertExists('imagenes/2.jpg');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');
});
