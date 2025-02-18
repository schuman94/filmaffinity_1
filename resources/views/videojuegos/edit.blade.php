<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar videojuego
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('videojuegos.update', $videojuego) }}" class="max-w-sm mx-auto">
                @method('PUT')
                @csrf
                <div class="mb-5">
                    <x-input-label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Título
                    </x-input-label>
                    <x-text-input name="titulo" type="text" id="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('titulo', $videojuego->titulo)" />
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="desarrollador_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Desarrollador
                    </x-input-label>
                    <select name="desarrollador_id" id="desarrollador_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($desarrolladores as $desarrollador)
                            <option value="{{ $desarrollador->id }}" {{ $videojuego->desarrollador_id == $desarrollador->id ? 'selected' : '' }}>
                                {{ $desarrollador->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-5">
                    <x-input-label for="fecha_lanzamiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Fecha lanzamiento
                    </x-input-label>
                    <x-text-input name="fecha_lanzamiento" type="text" id="fecha_lanzamiento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('fecha_lanzamiento', fecha($videojuego->fecha_lanzamiento))" />
                    <x-input-error :messages="$errors->get('fecha_lanzamiento')" class="mt-2" />
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Editar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
