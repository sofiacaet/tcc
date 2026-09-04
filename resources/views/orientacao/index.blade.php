@extends('templates/main', [
    'titulo' => "Sistema Pré-Natal",
    'cabecalho' => 'Orientações e Observações',
    'rota' => '',
    'relatorio' => '',
    'class' => App\Models\Orientacao::class,
])

@section('conteudo')

<style>
/* Layout Principal estilo Chat */
.chat-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    min-height: 550px;
}

/* Painel Esquerdo - Lista de Pacientes */
.gestantes-list {
    border-right: 1px solid #e9ecef;
    background-color: #f8f9fa;
    height: 550px;
    overflow-y: auto;
}

.gestante-item {
    display: block;
    padding: 14px 16px;
    border-bottom: 1px solid #e9ecef;
    color: #333;
    text-decoration: none;
    transition: background 0.2s;
}

.gestante-item:hover {
    background-color: #e9ecef;
    color: #0775be;
}

.gestante-item.active {
    background-color: #0775be;
    color: #ffffff !important;
}

/* Painel Direito - Mensagens */
.chat-box {
    display: flex;
    flex-direction: column;
    height: 550px;
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background-color: #f4f6f8;
}

/* Bolhas de Mensagem */
.message-bubble {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 12px;
    position: relative;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.message-medico {
    background-color: #e3f2fd;
    color: #0d47a1;
    margin-right: auto; /* Alinhado à esquerda */
    border-bottom-left-radius: 2px;
}

.message-gestante {
    background-color: #ffffff;
    color: #212529;
    margin-left: auto; /* Alinhado à direita */
    border-bottom-right-radius: 2px;
}

.chat-input-area {
    padding: 15px;
    background: #ffffff;
    border-top: 1px solid #e9ecef;
}
</style>

<div class="chat-container">
    <div class="row g-0">
        
        {{-- COLUNA DA ESQUERDA: LISTA DE GESTANTES --}}
        <div class="col-md-4 col-lg-3 gestantes-list">
            <div class="p-3 bg-light border-bottom fw-bold text-secondary d-flex align-items-center gap-2">
                <span class="material-symbols-outlined">groups</span>
                <span>Pacientes</span>
            </div>

            @forelse($gestantes as $g)
                @if($g)
                    <a href="{{ route('orientacao.index', ['gestante_id' => $g->id]) }}" 
                       class="gestante-item {{ isset($gestanteSelecionada) && $gestanteSelecionada->id == $g->id ? 'active' : '' }}">
                        <div class="fw-bold">{{ $g->nome }}</div>
                        <small class="{{ isset($gestanteSelecionada) && $gestanteSelecionada->id == $g->id ? 'text-white-50' : 'text-muted' }}">
                            {{ $g->cpf ?? 'Ver histórico' }}
                        </small>
                    </a>
                @endif
            @empty
                <div class="p-3 text-center text-muted">
                    Nenhuma gestante cadastrada.
                </div>
            @endforelse
        </div>

        {{-- COLUNA DA DIREITA: CONVERSA E ENVIO --}}
        <div class="col-md-8 col-lg-9 chat-box">
            @if($gestanteSelecionada)
                
                {{-- Cabeçalho da Gestante Selecionada --}}
                <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0 fw-bold text-primary">{{ $gestanteSelecionada->nome }}</h6>
                        <small class="text-muted">Prontuário de Comunicação Direta</small>
                    </div>
                </div>

                {{-- Histórico de Mensagens --}}
                <div class="chat-messages" id="chatMessages">
                    @forelse($orientacoes as $item)
                        @php
                            $isMedico = $item->user->role_id == 2;
                        @endphp

                        <div class="message-bubble {{ $isMedico ? 'message-medico' : 'message-gestante' }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="fw-bold me-2">
                                    {{ $item->user->name }} ({{ $isMedico ? 'Médico/Equipe' : 'Gestante' }})
                                </small>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div style="white-space: pre-line;">{{ $item->mensagem }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted my-5">
                            <span class="material-symbols-outlined fs-1 text-black-50">forum</span>
                            <p class="mt-2">Nenhuma orientação ou mensagem registrada com este paciente.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Área de Envio de Mensagem --}}
                @can('create', App\Models\Orientacao::class)
                    <div class="chat-input-area">
                        <form action="{{ route('orientacao.store') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="hidden" name="gestante_id" value="{{ $gestanteSelecionada->id }}">
                            
                            <textarea 
                                name="mensagem" 
                                class="form-control" 
                                rows="2" 
                                placeholder="Digite sua orientação ou mensagem aqui..." 
                                required
                            ></textarea>

                            <button type="submit" class="btn btn-tiffany d-flex align-items-center justify-content-center px-4">
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </form>
                    </div>
                @endcan

            @else
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                    <span class="material-symbols-outlined fs-1">person_search</span>
                    <p class="mt-2">Selecione uma gestante ao lado para visualizar as orientações.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    // Rola o chat automaticamente para a mensagem mais recente ao carregar
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatMessages");
        if(chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
</script>

@endsection