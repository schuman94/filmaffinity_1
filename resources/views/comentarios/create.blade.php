<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Responder Comentario
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('comentarios.responder', $comentario) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="contenido" class="block text-gray-700 text-sm font-bold mb-2">Tu respuesta:</label>
                        <textarea name="contenido" id="contenido" rows="4" class="w-full border rounded-lg p-2"></textarea>
                        @error('contenido')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Enviar respuesta
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
