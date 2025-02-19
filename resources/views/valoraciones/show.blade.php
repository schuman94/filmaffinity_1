<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver valoración
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Título
                            </dt>
                            <dd class="text-lg font-semibold">
                                @if ($valoracion->valorable instanceof App\Models\Pelicula)
                                    <a href="{{ route('peliculas.show', $valoracion->valorable) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        {{ $valoracion->valorable->titulo }}
                                    </a>
                                @elseif ($valoracion->valorable instanceof App\Models\Videojuego)
                                    <a href="{{ route('videojuegos.show', $valoracion->valorable) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        {{ $valoracion->valorable->titulo }}
                                    </a>
                                @else
                                    <span class="text-gray-500">No disponible</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Valorado por:
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $valoracion->user->name }}
                            </dd>
                        </div>
                    </dl>
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Puntuación
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $valoracion->puntuacion }}
                            </dd>
                        </div>
                    </dl>
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        @can('update-valoracion', $valoracion)
                        <div class="flex flex-col pb-3">
                            <dd class="text-lg font-semibold">
                                <a href="{{ route('valoraciones.edit', $valoracion) }}"class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Editar
                                </a>
                            </dd>
                        </div>
                        @endcan
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Comentario
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $valoracion->comentario }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
