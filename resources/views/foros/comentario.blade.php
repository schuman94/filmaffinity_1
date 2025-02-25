@php
    $espaciado = $nivel * 20; // Espaciado para respuestas anidadas
@endphp

<div class="ml-{{ $espaciado }} mt-4 p-4 border-l-4 border-gray-300 bg-gray-100 rounded-lg">
    <div class="flex items-center justify-between">
        <p class="font-semibold text-gray-900">{{ $comentario->user->name }}</p>
        <span class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</span>
    </div>
    <p class="mt-2 text-gray-700">{{ $comentario->contenido }}</p>


    <div class="mt-2">
        <a href="{{ route('comentarios.redactar_respuesta', $comentario) }}"
           class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
            Responder
        </a>
    </div>

    <!-- Mostrar respuestas de forma recursiva -->
    @foreach ($comentario->comentarios as $subcomentario)
        @include('foros.comentario', ['comentario' => $subcomentario, 'nivel' => $nivel + 1])
    @endforeach
</div>
