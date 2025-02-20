<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver videojuego
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
                                {{ $videojuego->titulo }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Desarrollador
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $videojuego->desarrollador->nombre }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Fecha lanzamiento
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ fecha($videojuego->fecha_lanzamiento) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="relative overflow-x-auto mt-10">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Generos
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videojuego->generos as $genero)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('generos.show', $genero) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        {{ $genero->nombre }}
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @can('anyadir-genero')
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <form method="POST" action="{{ route('videojuegos.anyadir_genero', $videojuego) }}" class="max-w-sm mx-auto">
                        @method('PUT')
                        @csrf
                        <div class="mb-5">
                            <x-input-label for="genero_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Género
                            </x-input-label>
                            <select name="genero_id" id="genero_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($generos as $genero)
                                    <option value="{{ $genero->id }}">
                                        {{ $genero->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Mostrar el error específico para 'genero_id' -->
                            @error('genero_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Añadir género
                        </button>
                    </form>
                </div>
            </div>
            @endcan

            <div class="relative overflow-x-auto mt-10">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Valoraciones: {{ " " . $videojuego->valoraciones->count()}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Puntuación
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Comentario
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videojuego->valoraciones as $valoracion)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('valoraciones.show', $valoracion) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        {{ $valoracion->user->name }}
                                    </a>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $valoracion->puntuacion }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('valoraciones.show', $valoracion) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Ver comentario
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @cannot('videojuego-valorado', $videojuego)
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <form method="POST" action="{{ route('videojuegos.valorar', $videojuego) }}" class="max-w-sm mx-auto">
                        @method('PUT')
                        @csrf
                        <div class="mb-5">
                            <x-input-label for="puntuacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Puntuación
                            </x-input-label>
                            <x-text-input name="puntuacion" type="number" id="puntuacion"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :value="old('puntuacion')" min="1" max="10" step="1" />
                            <x-input-error :messages="$errors->get('puntuacion')" class="mt-2" />
                        </div>

                        <div class="mb-5">
                            <x-input-label for="comentario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Comentario
                            </x-input-label>
                            <textarea name="comentario" id="comentario" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('comentario') }}</textarea>
                            <x-input-error :messages="$errors->get('comentario')" class="mt-2" />
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Valorar
                        </button>
                    </form>
                </div>
            </div>
            @endcannot
        </div>
    </div>
</x-app-layout>
