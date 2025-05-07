<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulo de Emergência') }}
        </h2>
    </x-slot>
    <div class="py-8 bg-blue-900 flex items-center justify-center mt-6 sm:mt-0">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-500/30 backdrop-blur-md border border-white/20 rounded-lg shadow-lg p-8 text-center">
                <h2>Aguardando confirmação da equipe...</h2>
                <p>ID do atendimento: {{ $atendimento->id }}</p>
                <p>Status: {{ $atendimento->status }}</p>
                @csrf
                <script>
                    // Verifica a confirmação a cada 3 segundos
                    const rotaAguardando = @json(route('telegram.verificar');)
                    const interval = setInterval(() => {
                        fetch(rotaAguardando, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Erro na requisição');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.confirmado) {
                                    clearInterval(interval); // Parar o intervalo ao receber a confirmação
                                    window.location.href = '/confirmacao'; // Redireciona para a página de confirmação
                                }
                            })
                            .catch(error => {
                                console.error('Erro ao verificar confirmação:', error);
                            });
                    }, 3000);
                
                    // Exibe alerta após 60 segundos se nenhuma confirmação for recebida
                    setTimeout(() => {
                        clearInterval(interval); // Para o intervalo após o tempo limite
                        alert("Nenhuma confirmação recebida. Por favor, tente novamente ou acione o suporte.");
                    }, 60000);
                </script>
            </div>
        </div>
    </div>
</x-app-layout>