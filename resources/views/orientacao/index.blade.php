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
    background-color: #eaf3f3;
    color: #275553;
}

.gestante-item.active {
    background-color: #275553;
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
    display: flex;
    flex-direction: column;
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

/* Mensagem enviada pelo USUÁRIO LOGADO (Minhas mensagens -> Direita + Verde Petróleo) */
.message-me {
    background-color: #275553;
    color: #ffffff;
    margin-left: auto; /* Alinhado à direita */
    border-bottom-right-radius: 2px;
}

.message-me .text-muted {
    color: #d1e2e2 !important;
}

/* Mensagem enviada pelo OUTRO USUÁRIO (Mensagens recebidas -> Esquerda + Branco/Cinza Claro) */
.message-other {
    background-color: #ffffff;
    color: #212529;
    margin-right: auto; /* Alinhado à esquerda */
    border-bottom-left-radius: 2px;
    border: 1px solid #e9ecef;
}

.chat-input-area {
    padding: 15px;
    background: #ffffff;
    border-top: 1px solid #e9ecef;
}

.btn-petroleo {
    background-color: #275553;
    color: #ffffff;
    border: none;
    transition: background 0.2s;
}

.btn-petroleo:hover {
    background-color: #1f4442;
    color: #ffffff;
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
                        <h6 class="mb-0 fw-bold" style="color: #275553;">{{ $gestanteSelecionada->nome }}</h6>
                        <small class="text-muted">Prontuário de Comunicação Direta</small>
                    </div>
                </div>

                {{-- Histórico de Mensagens --}}
                <div class="chat-messages" id="chatMessages">
                    @forelse($orientacoes as $item)
                        @php
                            // Verifica se a mensagem pertence ao usuário atualmente logado
                            $isMe = $item->user_id == auth()->id();
                            $isMedico = $item->user->role_id == 2;
                        @endphp

                        <div class="message-bubble {{ $isMe ? 'message-me' : 'message-other' }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="fw-bold me-3">
                                    {{ $isMe ? 'Você' : $item->user->name . ' (' . ($isMedico ? 'Médico/Equipe' : 'Gestante') . ')' }}
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

                            <button type="submit" class="btn btn-petroleo d-flex align-items-center justify-content-center px-4">
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
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chatMessages");
        if(chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
</script>

@endsection