<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p><h1>{{ __("Lista de Atendimentos") }}</h1></p>
                    @foreach ($atendimentos as $atendimento)
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold">(ID:{{ $atendimento->id }})</h2>
                            <p class="text-gray-800">{{ $atendimento->status }}</p>
                            <p class="text-sm text-gray-500">Criado em: {{ $atendimento->created_at }}</p>
                            <p class="text-sm text-gray-500">Atualizado em: {{ $atendimento->updated_at }}</p>
                            <p class="text-sm text-gray-500">Confirmado em: {{ $atendimento->dataConfirmado }}</p>   
                        </div>
                        <hr>                   
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
