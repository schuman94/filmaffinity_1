<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear película
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('peliculas.store') }}" class="max-w-sm mx-auto">
                @csrf
                <div class="mb-5">
                    <x-input-label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Título
                    </x-input-label>
                    <x-text-input name="titulo" type="text" id="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('titulo')" />
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="director" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Director
                    </x-input-label>
                    <x-text-input name="director" type="text" id="director" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('director')" />
                    <x-input-error :messages="$errors->get('director')" class="mt-2" />
                </div>

                <div class="mb-5">
                    <x-input-label for="fecha_estreno" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Fecha estreno
                    </x-input-label>
                    <x-text-input name="fecha_estreno" type="text" id="fecha_estreno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('fecha_estreno')" />
                    <x-input-error :messages="$errors->get('fecha_estreno')" class="mt-2" />
                </div>

                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Crear
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
