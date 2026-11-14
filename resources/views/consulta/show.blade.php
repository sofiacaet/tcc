@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Detalhes da Consulta Realizada',
    'rota' => '',
    'relatorio' => '',
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
    padding: 22px;
    color: #275553;
    overflow: auto;
}

/* CARD GLASS (Igual aos formulários) */
.details-card {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(14px);
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(39, 85, 83, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.4);
    margin-top: 18px;
}

/* TÍTULOS DAS SEÇÕES */
.texto-info {
    color: var(--green-strong);
    font-weight: 700;
}

/* CAIXINHAS DE INFORMAÇÃO (Adaptadas para o tema claro translúcido) */
.info-box {
    background: rgba(255, 255, 255, 0.65); 
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(39, 85, 83, 0.05);
    border: 1px solid rgba(255,255,255,0.5);
    transition: 0.3s ease;
}

.info-box:hover {
    background: rgba(255, 255, 255, 0.85);
    box-shadow: 0 4px 15px rgba(39, 85, 83, 0.1);
}

.info-label {
    color: var(--green-light) !important;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    display: block;
}

.info-value {
    color: #275553;
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 0;
}

/* BOTÃO DE VOLTAR */
.btn-custom-back {
    border: 2px solid #275553;
    color: #275553;
    background: transparent;
    border-radius: 28px;
    padding: 8px 20px;
    font-weight: 700;
    transition: .2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-custom-back:hover,
.btn-custom-back:focus,
.btn-custom-back:active {
    background: var(--green-strong) !important;
    border-color: var(--green-strong) !important;
    color: #fff !important;
    transform: translateY(-2px);
}
</style>

<div class="details-card">
    
    <h5 class="mb-4 texto-info">Dados do Agendamento</h5>
    
   <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Gestante</span>
                <div class="info-value">{{ $consulta->gestante->nome }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Tipo de Consulta</span>
                <div class="info-value">{{ $consulta->tipo_consulta }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Local da Consulta</span>
                <div class="info-value">{{ $consulta->local ?? 'Não informado' }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Data</span>
                <div class="info-value">{{ \Carbon\Carbon::parse($consulta->data)->format('d/m/Y') }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Horário</span>
                <div class="info-value">{{ \Carbon\Carbon::parse($consulta->horario)->format('H:i') }} hs</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Status</span>
                <div class="info-value" style="color: var(--green);">
                    <span class="material-symbols-outlined align-middle" style="font-size: 1.2rem;">check_circle</span> 
                    {{ $consulta->status }}
                </div>
            </div>
        </div>
    </div>

    {{-- Linha divisória adaptada para o tema verde --}}
    <hr class="my-4" style="border-color: rgba(39, 85, 83, 0.2)">
    
    <h5 class="mb-4 texto-info">Registro Clínico Realizado</h5>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Peso da Gestante</span>
                <div class="info-value">{{ $consulta->peso_atual }} kg</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Pressão Arterial</span>
                <div class="info-value">{{ $consulta->pressao_arterial }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Batimentos Fetais (BCF)</span>
                <div class="info-value">{{ $consulta->batimentos_fetais }} bpm</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="info-box">
                <span class="info-label">Evolução Clínica / Anotações</span>
                <div class="info-value" style="white-space: pre-wrap; min-height: 60px;">{{ $consulta->evolucao_clinica }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <a href="{{ route('consulta.index') }}" class="btn btn-custom-back">
                <span class="material-symbols-outlined align-middle">arrow_back</span> Voltar para a Lista
            </a>
        </div>
    </div>

</div>

@endsection