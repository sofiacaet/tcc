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
    --green: #4197d9;
    --green-strong: #70a1de;
    --green-light: #195a71;
    --danger: #ff5c5c;
}

/* FUNDO */
body {
    background: linear-gradient(135deg, #75c8ff 0%, #4dabf8 50%, #193b68 100%);
    min-height: 100vh;
    padding: 22px;
    overflow: auto;
    color: #fff;
}

/* PARTÍCULAS NUTRICIONAIS FLUTUANDO */
.nutri {
    position: absolute;
    font-size: 26px;
    opacity: 0.85;
    animation: floatNutri 14s linear infinite;
    pointer-events: none;
    filter: drop-shadow(0 3px 6px rgba(0,0,0,0.25));
}

@keyframes floatNutri {
    0% { transform: translateY(110vh) rotate(0deg) scale(0.9); opacity: .2; }
    40% { opacity: 1; }
    100% { transform: translateY(-20vh) rotate(360deg) scale(1.3); opacity: 0; }
}

/* CARD FORM */
.form-card {
    background: rgba(255,255,255,0.16);
    backdrop-filter: blur(14px);
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22);
    margin-top: 18px;
}

/* INPUTS */


.form-floating > .form-control {
    background: rgba(255, 255, 255, 0.90) !important; /* QUASE BRANCO */
    border: 2px solid transparent;
    color: #333;
    border-radius: 12px !important;
    transition: .25s;
    font-weight: 600;
}

.form-floating .form-control::placeholder {
    color: #666 !important;
}

.form-floating > .form-control:focus {
    border-color: var(--green-light);
    background: rgba(255, 255, 255, 1) !important; /* 100% branco ao focar */
    box-shadow: 0 0 12px rgb(88, 185, 254);
    color: #222;
}

/* LABEL */
.form-floating label {
    color: #195a71 !important;
    font-weight: 700;
    text-shadow: 0 0 2px rgba(255,255,255,0.4);
}

.texto-info {
    color: #195a71;
    font-weight: 700;
    text-shadow: 0 0 2px rgba(255,255,255,0.4);
}

/* BOTÕES */
.btn-custom-back {
    border: 2px solid #e7eee9;
    color: #fff;
    border-radius: 28px;
    padding: 8px 20px;
    transition: .2s;
    background: rgba(255,255,255,0.10);
}

.btn-custom-back:hover {
    background: rgba(255,255,255,0.30);
}

.btn-custom-confirm {
    border: 2px solid var(--green-light);
    background: var(--green);
    border-radius: 28px;
    padding: 8px 22px;
    color: #fff;
    font-weight: 700;
    transition: .2s;
    box-shadow: 0 0 10px rgb(88, 185, 254);
}

.btn-custom-confirm:hover {
    background: var(--green-strong);
    box-shadow: 0 0 18px rgb(88, 185, 254);
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
    <div class="row mb-3">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text bg-secondary text-white">Gestante</span>
                <select class="form-select form-control" disabled>
                    @foreach ($gestantes as $item)
                        <option value="{{$item->id}}" @if($item->id == $consulta->gestante_id) selected @endif>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
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

    

    <hr class="my-4" style="border-color: rgba(255,255,255,0.2)">
    <h5 class="mb-4 texto-info">Registro Clínico (Atendimento)</h5>

    {{-- NOVOS CAMPOS: PESO, PRESSÃO E BATIMENTOS FETAIS --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-floating mb-4">
                <input type="number" step="0.01" class="form-control" name="peso_atual" placeholder="Peso Atual (kg)" value="{{ old('peso_atual', $consulta->peso_atual) }}" required />
                <label for="peso_atual">Peso Atual (kg)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating mb-4">
                <input type="text" class="form-control" name="pressao_arterial" placeholder="Ex: 12/8" value="{{ old('pressao_arterial', $consulta->pressao_arterial) }}" required />
                <label for="pressao_arterial">Pressão Arterial</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-floating mb-4">
                <input type="number" class="form-control" name="batimentos_fetais" placeholder="BCF (bpm)" value="{{ old('batimentos_fetais', $consulta->batimentos_fetais) }}" required />
                <label for="batimentos_fetais">Batimentos Fetais (bpm)</label>
            </div>
        </div>
    </div>

    {{-- NOVO CAMPO: EVOLUÇÃO CLÍNICA --}}
    <div class="row">
        <div class="col">
            <div class="form-floating mb-4">
                <textarea class="form-control" name="evolucao_clinica" placeholder="Evolução Clínica / Anotações" style="height: 120px; background: rgba(255, 255, 255, 0.90) !important;" required>{{ old('evolucao_clinica', $consulta->evolucao_clinica) }}</textarea>
                <label for="evolucao_clinica">Evolução Clínica / Anotações Médicas</label>
            </div>
        </div>
    </div>

    {{-- BOTÕES --}}
    <div class="row mt-4">
        <div class="col d-flex gap-3">
            <a href="{{route('consulta.index')}}" class="btn btn-custom-back">
                <span class="material-symbols-outlined align-middle">arrow_back</span> Voltar
            </a> 

            <button type="submit" class="btn btn-custom-back ms-auto">
                <span class="material-symbols-outlined align-middle">check_circle</span> Registrar
            </button>
        </div>
    </div>
</form>

</div>

@endsection
