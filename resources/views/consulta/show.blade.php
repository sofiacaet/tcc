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
    --green: #4197d9;
    --green-strong: #70a1de;
    --green-light: #195a71;
}

body {
    background: linear-gradient(135deg, #75c8ff 0%, #4dabf8 50%, #193b68 100%);
    min-height: 100vh;
    padding: 22px;
    color: #fff;
}

.details-card {
    background: rgba(255,255,255,0.16);
    backdrop-filter: blur(14px);
    padding: 32px;
    border-radius: 18px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22);
    margin-top: 18px;
}



.texto-info {
    color: #195a71;
    font-weight: 700;
    text-shadow: 0 0 2px rgba(255,255,255,0.4);
}

/* NOVO: Container unificado para o título + valor */
.info-box {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 10px 16px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* ALTERADO: Agora fica no topo da caixinha */
.info-label {
    color: #195a71 !important;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
    display: block;
}

/* ALTERADO: Removeu o fundo próprio para reutilizar o da .info-box */
.info-value {
    color: #333;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0;
}

.btn-custom-back {
    border: 2px solid #e7eee9;
    color: #fff;
    border-radius: 28px;
    padding: 8px 20px;
    transition: .2s;
    background: rgba(255,255,255,0.10);
    text-decoration: none;
    display: inline-block;
}

.btn-custom-back:hover {
    background: rgba(255,255,255,0.30);
    color: #fff;
}
</style>

<div class="details-card">
    
    <h5 class="mb-4 texto-info">Dados do Agendamento</h5>
    
    <div class="row">
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-label">Gestante</span>
                <div class="info-value">{{ $consulta->gestante->nome }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-label">Tipo de Consulta</span>
                <div class="info-value">{{ $consulta->tipo_consulta }}</div>
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
                <div class="info-value text-success">✅ {{ $consulta->status }}</div>
            </div>
        </div>
    </div>

    <hr class="my-4" style="border-color: rgba(255,255,255,0.2)">
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