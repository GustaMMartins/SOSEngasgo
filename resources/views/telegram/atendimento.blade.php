<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Módulo de Emergência') }}
        </h2>
    </x-slot>
    <div class="py-8 bg-blue-900 flex items-center justify-center mt-6 sm:mt-0">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-500/30 backdrop-blur-md border border-white/20 rounded-lg shadow-lg p-8 text-center">
                <label for="atendimento" class="block mb-6 text-2xl font-semibold text-gray-900">
                    Iniciar atendimento emergencial
                </label>
                <form method="POST" action="/iniciar">
                    @csrf
                    <input type="hidden" name="atendimento" value="1">
                    <button type="submit" class="text-white bg-blue-600/0 hover:bg-blue-600focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-full text-xl px-5 py-10 shadow-lg transform transition hover:scale-105">
                        ⚠️ Iniciar Atendimento Emergencial
                    </button>
                </form>
                <p class="mt-6 text-lg text-gray-900">
                    Toque aqui para acionar ajuda e iniciar as instruções
                </p>
            </div>
        </div>
    </div>
</x-app-layout>