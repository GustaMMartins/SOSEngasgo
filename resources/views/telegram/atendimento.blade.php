<x-app-layout>
   <x-slot name="header">
    <h2 class="font-extrabold text-3xl text-red-600 text-center leading-tight font-quicksand mx-auto">
        {{ __('SOS ENGASGO') }}
    </h2>
</x-slot>
    @vite(['resources/js/localiza.js'])
    <div class="py-8 bg-red-500 flex items-ceter justify-center mt-6 sm:mt-0">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
           
            <div class="bg-white backdrop-blur-md border-white/20 rounded-lg shadow-lg p-12 flex flex-col items-center justify-center">

                <img src="{{ asset('img/cruz.png') }}" alt="SOS Engasgo" class="mb-6 h-24">
    
                <label for="atendimento" class="block mb-6 text-2xl font-semibold text-gray-900">                    
                </label>

                <form method="POST" action="{{ route('telegram.atendimento.iniciar') }}" onsubmit="return enviarLocalizacao(event)">
                    @csrf
                    <input type="hidden" name="atendimento" value="1">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4"
                   style="display: inline-block; padding: 0.75rem 1.25rem; border-radius: 0.375rem; text-decoration: none; text-align: center; cursor: pointer;">
                        ⚠️ Iniciar Atendimento Emergencial
                    </button>
                </form>
<!-- ação transferida para o botão Iniciar Atendimento Emergencial
                <button onclick="enviarLocalizacao()" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4"
                   style="display: inline-block; padding: 0.75rem 1.25rem; border-radius: 0.375rem; text-decoration: none; text-align: center; cursor: pointer;">
                Enviar Localização para o Telegram
                </button>
            -->
                <a href="https://www.youtube.com/watch?v=VIDEO_ID_AQUI" target="_blank" rel="noopener noreferrer"
                   class="text-black bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                   style="display: inline-block; padding: 0.53rem 1.20rem; border-radius: 0.353rem; text-decoration: none; text-align: center; cursor: pointer;">
                    <p class="mt-6 text-lg text-gray-900"> 
                      Toque aqui para visualizar as instruções
                    </p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>