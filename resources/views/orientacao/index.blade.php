@extends('templates/main', [
    'titulo' => "Sistema Pré-Natal",
    'cabecalho' => 'Orientações e Observações',
    'rota' => '',
    'relatorio' => '',
    'class' => App\Models\Orientacao::class,
])

@section('conteudo')

<style>
:root{
    /* Cores: Tons de verde/teal da nova identidade */
    --green: #2b7a78;         
    --green-strong: #1d5250;  
    --green-light: #489996;   
    --danger: #e63946;        
}

/* FUNDO PRINCIPAL */
body {
    background-color: #c5dede;
    min-height: 100vh;
    padding-bottom: 20px;
    overflow: auto;
    color: #275553; 
}

/* CONTAINER PRINCIPAL DO CHAT */
.chat-container {
    background-color: #c5dede; /* Mesmo verde do fundo */
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22); /* Sombreamento escuro igual da tabela */
    border: 1px solid rgba(255, 255, 255, 0.4);
    overflow: hidden;
    min-height: 550px;
    margin-top: 18px;
}

/* CABEÇALHOS E RODAPÉ - GRADIENTE VERDE DA TABELA */
.chat-header-gradient {
    background: linear-gradient(90deg, var(--green), var(--green-light));
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    z-index: 10;
    position: relative;
}

.chat-header-gradient h6, 
.chat-header-gradient small, 
.chat-header-gradient span {
    color: #fff !important; 
}

/* Painel Esquerdo - Lista de Pacientes */
.gestantes-list {
    border-right: 1px solid rgba(255, 255, 255, 0.3);
    background-color: #c5dede; /* Mesmo verde do fundo */
    height: 550px;
    overflow-y: auto;
}

.gestante-item {
    display: block;
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--green-strong); 
    text-decoration: none;
    transition: background 0.2s;
}

.gestante-item:hover {
    background-color: rgba(255, 255, 255, 0.3);
    color: var(--green-strong);
}

.gestante-item.active {
    background-color: rgba(255, 255, 255, 0.5); 
    color: var(--green-strong) !important;
    font-weight: bold;
    border-left: 4px solid var(--green);
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
    background-color: #c5dede; /* Mesmo verde do fundo */
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

/* Minhas Mensagens */
.message-me {
    background-color: var(--green); 
    color: #ffffff;
    margin-left: auto; 
    border-bottom-right-radius: 2px;
}

.message-me .text-muted {
    color: rgba(255,255,255,0.7) !important; 
}

/* Mensagens Recebidas */
.message-other {
    background: #ffffff; 
    color: var(--green-strong); 
    margin-right: auto; 
    border-bottom-left-radius: 2px;
    border: 1px solid rgba(255,255,255,0.6);
}

.message-other .text-muted {
    color: var(--green-light) !important;
}

/* Área de Envio de Mensagens */
.chat-input-area {
    padding: 15px;
    border-top: none;
}

.chat-input-area textarea {
    border-radius: 8px;
    border: none;
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
    resize: none;
}

/* Botão de Enviar Simples */
.btn-petroleo {
    background-color: var(--green-strong);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    padding: 10px 16px;
    transition: background 0.2s;
}

.btn-petroleo:hover {
    background-color: #143a39; /* Apenas escurece um pouco no hover */
    color: #ffffff;
}
</style>

<div class="chat-container">
    <div class="row g-0">
        
        {{-- COLUNA DA ESQUERDA: LISTA DE PACIENTES (APARECE APENAS PARA O MÉDICO) --}}
        @if(auth()->user()->role_id == 2)
            <div class="col-md-4 col-lg-3 gestantes-list">
                <div class="p-3 border-bottom d-flex align-items-center gap-3" style="background-color: #ffffffa6;">
                    <span class="material-symbols-outlined" style="color: var(--green-strong); font-size: 28px;">groups</span>
                    <div>
                        <h6 class="mb-0 fw-bold" style="color: var(--green-strong);">Pacientes</h6>
                    </div>
                </div>

                @forelse($gestantes->where('status', 'Em acompanhamento') as $g)
                    @if($g)
                        <a href="{{ route('orientacao.index', ['gestante_id' => $g->id]) }}" 
                           class="gestante-item {{ isset($gestanteSelecionada) && $gestanteSelecionada->id == $g->id ? 'active' : '' }}">
                            <div class="fw-bold">{{ $g->nome }}</div>
                        </a>
                    @endif
                @empty
                    <div class="p-3 text-center text-muted">
                        Nenhuma gestante cadastrada.
                    </div>
                @endforelse
            </div>
        @endif

        {{-- COLUNA DA DIREITA: CONVERSA E ENVIO --}}
        {{-- Se for médico (2) ocupa o resto da tela (col-md-8 col-lg-9). Se for paciente, ocupa a tela TODA (col-12) --}}
        <div class="{{ auth()->user()->role_id == 2 ? 'col-md-8 col-lg-9' : 'col-12' }} chat-box">
            
            @if($gestanteSelecionada)
                
                {{-- Cabeçalho da Conversa --}}
                <div class="p-3 border-bottom  d-flex align-items-center justify-content-between" style="background-color: #ffffffa6; height: 61px; ">
                    <div>
                        @if(auth()->user()->role_id == 2)
                            <h6 class="mb-0 fw-bold" style="color: #275553;">{{ $gestanteSelecionada->nome }}</h6>   
                        @else
                            <h6 class="mb-0 fw-bold" style="color: #275553;">Equipe Médica - Gestapguá</h6>
                        @endif
                    </div>
                </div>

                {{-- Histórico de Mensagens --}}
                <div class="chat-messages" id="chatMessages">
                    @forelse($orientacoes as $item)
                        @php
                            $isMe = $item->user_id == auth()->id();
                            $isMedico = $item->user->role_id == 2;
                        @endphp

                        <div class="message-bubble {{ $isMe ? 'message-me' : 'message-other' }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="fw-bold me-3">
                                    {{ $isMe ? 'Você' : $item->user->name . ' (' . ($isMedico ? 'Médico' : 'Gestante') . ')' }}
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
                                placeholder="Digite sua mensagem aqui..." 
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