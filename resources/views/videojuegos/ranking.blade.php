<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ranking de Videojuegos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Filtrar Ranking de Videojuegos</h3>
                <form method="GET" action="{{ route('videojuegos.ranking') }}" class="grid grid-cols-2 gap-3">

                    <!-- Filtro por fecha de estreno -->
                    <div>
                        <x-input-label for="fecha_inicio"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Desde
                        </x-input-label>
                        <x-text-input name="fecha_inicio" type="date" id="fecha_inicio"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :value="request('fecha_inicio')" />
                        <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fecha_fin"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Hasta
                        </x-input-label>
                        <x-text-input name="fecha_fin" type="date" id="fecha_fin"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :value="request('fecha_fin')" />
                        <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
                    </div>

                    <!-- Filtro por género -->
                    <div>
                        <x-input-label for="genero_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Género
                        </x-input-label>
                        <select name="genero_id" id="genero_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Todos</option>
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}"
                                    {{ request('genero_id') == $genero->id ? 'selected' : '' }}>
                                    {{ $genero->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('genero_id')" class="mt-2" />
                    </div>

                    <!-- Filtro por desarrollador -->
                    <div class="col-span-3">
                        <x-input-label for="desarrollador"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Desarrollador
                        </x-input-label>
                        <x-text-input name="desarrollador" type="text" id="desarrollador"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :value="request('desarrollador')" placeholder="Buscar por desarrollador" />
                        <x-input-error :messages="$errors->get('desarrollador')" class="mt-2" />
                    </div>

                    <!-- Filtro por puntuación mínima -->
                    <div>
                        <x-input-label for="puntuacion_minima"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Puntuación mínima
                        </x-input-label>
                        <x-text-input name="puntuacion_minima" type="number" id="puntuacion_minima" min="0"
                            max="10"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :value="request('puntuacion_minima', 0)" />
                        <x-input-error :messages="$errors->get('puntuacion_minima')" class="mt-2" />
                    </div>

                    <!-- Botón de filtrar -->
                    <div class="col-span-3">
                        <br>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Aplicar
                        </button>
                    </div>
                </form>
            </div>
            <div class="mt-6">
                @if ($videojuegos->count())
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Posición
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Título
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Desarrollador
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Fecha lanzamiento
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Puntuacion
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 0;
                            @endphp
                            @foreach ($videojuegos as $videojuego)
                                @php
                                    $contador++;
                                @endphp
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $contador}}
                                    </th>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('videojuegos.show', $videojuego) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            {{ $videojuego->titulo }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $videojuego->desarrollador->nombre }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ fecha($videojuego->fecha_lanzamiento) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ numero_2_decimales($videojuego->valoraciones->pluck('puntuacion')->avg()) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="mt-4 text-gray-500">No se encontraron videojuegos con los filtros seleccionados.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
