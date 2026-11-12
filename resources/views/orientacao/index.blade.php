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
    background-color: #c5dede; 
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22); 
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

/* Painel Esquerdo - Lista de Pacientes/Médicos */
.gestantes-list {
    border-right: 1px solid rgba(255, 255, 255, 0.3);
    background-color: #c5dede; 
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
    background-color: #c5dede; 
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
    background-color: #143a39; 
    color: #ffffff;
}
</style>

<div class="chat-container">
    <div class="row g-0">
        
        {{-- COLUNA DA ESQUERDA: LISTA DE CONTATOS --}}
        <div class="col-md-4 col-lg-3 gestantes-list">
            <div class="p-3 border-bottom d-flex align-items-center gap-3" style="background-color: #ffffffa6;">
                <span class="material-symbols-outlined" style="color: var(--green-strong); font-size: 28px;">
                    {{ auth()->user()->role_id == 2 ? 'groups' : 'medical_services' }}
                </span>
                <div>
                    <h6 class="mb-0 fw-bold" style="color: var(--green-strong);">
                        {{ auth()->user()->role_id == 2 ? 'Pacientes' : 'Equipe Médica' }}
                    </h6>
                </div>
            </div>

            @if(auth()->user()->role_id == 2)
                {{-- Visão do Médico: Lista as Gestantes --}}
                @forelse($gestantes as $g)
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
            @else
                {{-- Visão da Gestante: Lista os Médicos --}}
                @forelse($medicos as $m)
                    @if($m)
                        <a href="{{ route('orientacao.index', ['medico_id' => $m->id]) }}" 
                           class="gestante-item {{ isset($medicoSelecionado) && $medicoSelecionado->id == $m->id ? 'active' : '' }}">
                            <div class="fw-bold">Dr(a). {{ $m->name }}</div>
                        </a>
                    @endif
                @empty
                    <div class="p-3 text-center text-muted">
                        Nenhum médico disponível.
                    </div>
                @endforelse
            @endif
        </div>

        {{-- COLUNA DA DIREITA: CONVERSA E ENVIO --}}
        <div class="col-md-8 col-lg-9 chat-box">
            
            {{-- Verifica se uma conversa foi selecionada --}}
            @if((auth()->user()->role_id == 2 && isset($gestanteSelecionada)) || (auth()->user()->role_id != 2 && isset($medicoSelecionado)))
                
                {{-- Cabeçalho da Conversa --}}
                <div class="p-3 border-bottom  d-flex align-items-center justify-content-between" style="background-color: #ffffffa6; height: 61px; ">
                    <div>
                        @if(auth()->user()->role_id == 2)
                            <h6 class="mb-0 fw-bold" style="color: #275553;">{{ $gestanteSelecionada->nome }}</h6>   
                        @else
                            <h6 class="mb-0 fw-bold" style="color: #275553;">Dr(a). {{ $medicoSelecionado->name }}</h6>
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
                            <p class="mt-2">
                                {{ auth()->user()->role_id == 2 ? 'Nenhuma orientação ou mensagem registrada com este paciente.' : 'Inicie uma conversa com a equipe médica.' }}
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Área de Envio de Mensagem --}}
                @can('create', App\Models\Orientacao::class)
                    <div class="chat-input-area">
                        <form action="{{ route('orientacao.store') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            
                            {{-- Se for médico, passa a gestante selecionada. Se for gestante, não precisa passar ID de gestante pois a controller descobre pelo email do usuário logado --}}
                            @if(auth()->user()->role_id == 2)
                                <input type="hidden" name="gestante_id" value="{{ $gestanteSelecionada->id }}">
                            @endif
                            
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
                    <p class="mt-2">Selecione uma opção ao lado para visualizar as orientações.</p>
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