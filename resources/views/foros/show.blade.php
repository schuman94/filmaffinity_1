<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Foro
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
                                {{ $foro->forable->titulo }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6">
                <form method="POST" action="{{ route('comentarios.store') }}" class="bg-white p-6 rounded-lg shadow">
                    @csrf
                    <input type="hidden" name="comentable_type" value="{{ get_class($foro) }}">
                    <input type="hidden" name="comentable_id" value="{{ $foro->id }}">

                    <div class="mb-4">
                        <label for="contenido" class="block text-gray-700 text-sm font-bold mb-2">Escribe tu comentario:</label>
                        <textarea name="contenido" id="contenido" rows="3" class="w-full border rounded-lg p-2"></textarea>
                        @error('contenido')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Comentar
                    </button>
                </form>
            </div>

        @foreach ($foro->comentarios as $comentario)
            @include('foros.comentario', ['comentario' => $comentario, 'nivel' => 0])
        @endforeach

        </div>
    </div>
</x-app-layout>
