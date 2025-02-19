<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar valoración
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('valoraciones.update', $valoracion) }}" class="max-w-sm mx-auto">
                @method('PUT')
                @csrf
                <div class="mb-5">
                    <x-input-label for="puntuacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Puntuación
                    </x-input-label>
                    <x-text-input name="puntuacion" type="number" id="puntuacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('puntuacion', $valoracion->puntuacion)" min="1" max="10" step="1" />
                    <x-input-error :messages="$errors->get('puntuacion')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="comentario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Comentario
                    </x-input-label>
                    <textarea name="comentario" id="comentario" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-left">{{ old('comentario', $valoracion->comentario) }}</textarea>
                    <x-input-error :messages="$errors->get('comentario')" class="mt-2" />
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Editar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
