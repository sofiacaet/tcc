@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Registrar Consulta',
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
    overflow: auto;
    color: #275553; 
}

/* CARD GLASS (Igual aos outros formulários) */
.form-card {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(14px);
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(39, 85, 83, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.4);
    margin-top: 18px;
}

/* TÍTULOS DE SEÇÃO */
.texto-info {
    color: var(--green-strong);
    font-weight: 700;
}

/* INPUTS ADAPTADOS PARA O TEMA CLARO */
.form-floating > .form-control, 
.form-select {
    background: rgba(255, 255, 255, 0.65) !important;
    border: 2px solid transparent;
    color: #275553;
    border-radius: 12px !important;
    transition: .25s;
    font-weight: 600;
}

.form-floating .form-control::placeholder { 
    color: #5c8180 !important; 
}

.form-floating > .form-control:focus, 
.form-select:focus {
    border-color: var(--green-light);
    background: rgba(255, 255, 255, 0.95) !important;
    box-shadow: 0 0 12px rgba(43, 122, 120, 0.25);
    color: #1d5250;
}

/* ESTILO PARA INPUTS DESABILITADOS (Campos travados de agendamento) */
.form-control:disabled, .form-select:disabled {
    background: rgba(255, 255, 255, 0.35) !important;
    color: #5c8180 !important;
    border: 1px dashed rgba(39, 85, 83, 0.2);
}

/* LABEL DOS INPUTS */
.form-floating label {
    color: #275553 !important;
    font-weight: 700;
}

/* ESTILIZAÇÃO DO INPUT GROUP (Gestante bloqueada) */
.input-group-text.custom-group {
    background:  rgba(43, 122, 120, 0.6);
    color: #fff;
    border: none;
    border-radius: 12px 0 0 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.input-group > .form-select {
    border-radius: 0 12px 12px 0 !important;
}

/* BOTÕES ADAPTADOS AO TEMA */
.btn-custom-back {
    border: 2px solid #275553;
    color: #275553;
    background: transparent;
    border-radius: 28px;
    padding: 8px 20px;
    font-weight: 700;
    transition: .2s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-custom-back:hover,
.btn-custom-back:focus,
.btn-custom-back:active {
    background: var(--green-strong) !important;
    border-color: var(--green-strong) !important;
    color: #fff !important;
    transform: translateY(-2px);
}

.btn-custom-confirm {
    border: 2px solid var(--green);
    background: var(--green);
    border-radius: 28px;
    padding: 8px 22px;
    color: #fff;
    font-weight: 700;
    transition: .2s;
    box-shadow: 0 4px 15px rgba(43, 122, 120, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-custom-confirm:hover,
.btn-custom-confirm:focus,
.btn-custom-confirm:active {
    background: var(--green-strong) !important;
    border-color: var(--green-strong) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}


/* RESPONSIVO */
@media (max-width: 576px) {
    .form-card { padding: 18px; }
    .btn-custom-back, .btn-custom-confirm { 
        width: 100%; 
        margin-bottom: 10px; 
        justify-content: center;
    }
}
</style>

<div class="form-card">

<form action="{{route('consulta.update', $consulta->id)}}" method="POST">
    @csrf
    @method('PUT')

    {{-- TIPO DE CONSULTA (BLOQUEADO) --}}
    <div class="row">
        <div class="col">
            <div class="form-floating mb-4">
                <select id="tipo_consulta" class="form-select" disabled>
                    <option value="" disabled>Selecione o tipo de consulta</option>
                    <option value="Primeira Consulta" {{$consulta->tipo_consulta == 'Primeira Consulta' ? 'selected' : ''}}>1ª Consulta</option>
                    <option value="Consulta de Rotina" {{$consulta->tipo_consulta == 'Consulta de Rotina' ? 'selected' : ''}}>Consulta de Rotina</option>   
                    <option value="Consulta de Retorno" {{$consulta->tipo_consulta == 'Consulta de Retorno' ? 'selected' : ''}}>Consulta de Retorno (Exames)</option>
                    <option value="Consulta Especializada" {{$consulta->tipo_consulta == 'Consulta Especializada' ? 'selected' : ''}}>Consulta Especializada</option>
                </select>
                <label for="tipo_consulta">Tipo de Consulta (Agendada)</label>
            </div>
        </div>
    </div>

    {{-- GESTANTE (BLOQUEADO) --}}
    <div class="row mb-4">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text custom-group">Gestante</span>
                <select class="form-select" disabled>
                    @foreach ($gestantes as $item)
                        <option value="{{$item->id}}" @if($item->id == $consulta->gestante_id) selected @endif>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- LOCAL DA CONSULTA (BLOQUEADO) --}}
    <div class="row">
        <div class="col">
            <div class="form-floating mb-4">
                <input type="text" class="form-control" id="local" value="{{ $consulta->local }}" disabled />
                <label for="local">Local da Consulta</label>
            </div>
        </div>
    </div>
    
    {{-- DATA E HORÁRIO (BLOQUEADOS) --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-floating mb-4">
                <input type="date" class="form-control" id="data" value="{{$consulta->data}}" disabled />
                <label for="data">Data da Consulta</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating mb-4">
                <input type="time" class="form-control" id="horario" value="{{$consulta->horario}}" disabled />
                <label for="horario">Horário</label>
            </div>
        </div>
    </div>

    <hr class="my-4" style="border-color: rgba(39, 85, 83, 0.2)">
    <h5 class="mb-4 texto-info">Registro Clínico (Atendimento)</h5>

    {{-- NOVOS CAMPOS: PESO, PRESSÃO E BATIMENTOS FETAIS --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-floating mb-3 mb-md-0">
                <input type="number" step="0.01" class="form-control" name="peso_atual"  value="{{ old('peso_atual', $consulta->peso_atual) }}" required />
                <label for="peso_atual">Peso Atual (kg)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating mb-3 mb-md-0">
                <input type="text" class="form-control" name="pressao_arterial"  value="{{ old('pressao_arterial', $consulta->pressao_arterial) }}" required />
                <label for="pressao_arterial">Pressão Arterial</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating mb-3 mb-md-0">
                <input type="number" class="form-control" name="batimentos_fetais"  value="{{ old('batimentos_fetais', $consulta->batimentos_fetais) }}" required />
                <label for="batimentos_fetais">Batimentos Fetais (bpm)</label>
            </div>
        </div>
    </div>

    {{-- NOVO CAMPO: EVOLUÇÃO CLÍNICA --}}
    <div class="row mt-1">
        <div class="col">
            <div class="form-floating mb-4">
                <textarea class="form-control" name="evolucao_clinica" style="height: 120px;" required>{{ old('evolucao_clinica', $consulta->evolucao_clinica) }}</textarea>
                <label for="evolucao_clinica">Evolução Clínica / Anotações Médicas</label>
            </div>
        </div>
    </div>

    {{-- BOTÕES --}}
    <div class="row mt-2">
        <div class="col d-flex flex-wrap gap-3">
            <a href="{{route('consulta.index')}}" class="btn btn-custom-back">
                <span class="material-symbols-outlined align-middle">arrow_back</span> Voltar
            </a> 

            {{-- CORRIGIDO: Este botão estava com a classe 'btn-custom-back' errada no seu código original --}}
            <button type="submit" class="btn btn-custom-confirm ms-auto">
                <span class="material-symbols-outlined align-middle">check_circle</span> Registrar Atendimento
            </button>
        </div>
    </div>
</form>

</div>

@endsection