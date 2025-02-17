<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Videojuegos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-x-20">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Título
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Desarrollador
                                        </th>
                                        @auth
                                        <th scope="col" class="px-6 py-3">
                                            Adquiridos
                                        </th>
                                        @endauth
                                        <th colspan="3" scope="col" class="px-6 py-3">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videojuegos as $videojuego)
                                        <tr
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <a href="{{ route('videojuegos.show', $videojuego) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    {{ $videojuego->titulo }}
                                                </a>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $videojuego->desarrollador }}
                                            </td>
                                            @auth
                                            <td class="px-6 py-4">
                                                {{ Auth::user()->videojuegos->where('id', $videojuego->id)->first()?->pivot->cantidad /* Importante el "?" para que no de error si no existe */}}
                                            </td>
                                            @endauth
                                            <td class="px-6 py-4 flex items-center gap-2">
                                                <a href="{{ route('videojuegos.edit', $videojuego) }}"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    Editar
                                                </a>
                                                <form method="POST" action="{{ route('videojuegos.destroy', $videojuego) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit"
                                                        class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3"
                                                        onclick="return confirm('¿Está seguro?');">
                                                        Eliminar
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('videojuegos.adquirir', $videojuego) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="font-medium text-green-600 dark:text-green-500 hover:underline ms-3"
                                                        onclick="return confirm('¿Está seguro?');">
                                                        Adquirir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 text-center">
                            <a href="{{ route('videojuegos.create') }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Crear un nuevo videojuego
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
