<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ver cuenta
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Número
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $cuenta->numero }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                DNI
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $cuenta->cliente->dni }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Cliente
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ $cuenta->cliente->nombre }}
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                                Saldo actual
                            </dt>
                            <dd class="text-lg font-semibold">
                                {{ dinero($cuenta->saldo()) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <form method="GET" action="{{ route('cuentas.show', $cuenta) }}" class="max-w-sm mx-auto">
                        <div class="mb-5">
                            <x-input-label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Fecha
                            </x-input-label>
                            <x-text-input name="fecha" type="date" id="fecha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :value="old('fecha', $fecha)" />
                            <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Buscar
                        </button>
                    </form>
                </div>
            </div>

            <div class="relative overflow-x-auto mt-10">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Código
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Concepto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Importe
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Saldo parcial
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $saldo_parcial = 0;
                        @endphp

                        @foreach ($movimientos as $movimiento)
                            @php
                                $saldo_parcial += $movimiento->importe;
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $movimiento->codigo }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $movimiento->concepto }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ dinero($movimiento->importe) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ dinero($saldo_parcial) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ fecha($movimiento->created_at)}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
