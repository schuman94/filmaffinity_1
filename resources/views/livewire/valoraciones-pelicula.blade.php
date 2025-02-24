<div class="relative overflow-x-auto mt-10">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Valoraciones: {{ " " . $pelicula->valoraciones->count()}}
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
            @foreach ($pelicula->valoraciones as $valoracion)
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
    <button type="button" wire:click="eliminar" wire:confirm="¿Estás seguro que deseas eliminar todas las valoraciones?"
     class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium">
        Eliminar valoraciones
    </button>
</div>
