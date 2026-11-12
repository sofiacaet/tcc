@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Agendar Consulta',
    'rota' => '',
    'relatorio' => '',
])

@section('conteudo')

<style>
:root{
    /* Novas cores: Tons de verde/teal que combinam com o fundo #c5dede e texto #275553 */
    --green: #2b7a78;         /* Verde-água médio/elegante */
    --green-strong: #1d5250;  /* Verde escuro para efeitos de hover (passar o mouse) */
    --green-light: #489996;   /* Verde mais claro para destaques */
    --danger: #e63946;        /* Vermelho um pouco mais sóbrio para combinar com a paleta */
}

/* FUNDO */
body {
    background-color: #c5dede;
    min-height: 100vh;
    padding: 22px;
    overflow: auto;
    color: #275553; 
}

/* CARD GLASS */
.form-card {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(14px);
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(39, 85, 83, 0.15); /* Sombra agora puxa pro verde escuro, não pro preto */
    margin-top: 18px;
    border: 1px solid rgba(255, 255, 255, 0.4);
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

/* LABEL DOS INPUTS */
.form-floating label {
    color: #275553 !important;
    font-weight: 700;
}

/* ESTILIZAÇÃO DO INPUT GROUP (Gestante) */
.input-group-text.custom-group {
    background: linear-gradient(90deg, var(--green), var(--green-light));
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
}

.btn-custom-back:hover {
    background: #275553;
    color: #fff;
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
}

.btn-custom-confirm:hover {
    background: var(--green-strong);
    border-color: var(--green-strong);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(29, 82, 80, 0.3);
}

</style>

<div class="form-card">

<form action="{{route('consulta.store')}}" method="POST">
    @csrf

    {{-- TIPO DE CONSULTA --}}
    <div class="row">
        <div class="col">
            <div class="form-floating mb-4">
                <select name="tipo_consulta" id="tipo_consulta" class="form-select">
                    <option value="" disabled selected>Selecione</option>
                    <option value="Primeira Consulta" @if(old('tipo_consulta') == 'Primeira Consulta') selected @endif>1ª Consulta</option>
                    <option value="Consulta de Rotina" @if(old('tipo_consulta') == 'Consulta de Rotina') selected @endif>Consulta de Rotina</option>
                    <option value="Consulta de Retorno" @if(old('tipo_consulta') == 'Consulta de Retorno') selected @endif>Consulta de Retorno (Exames)</option>
                    <option value="Consulta Especializada" @if(old('tipo_consulta') == 'Consulta Especializada') selected @endif>Consulta Especializada</option>
                </select>
                <label for="tipo_consulta">Tipo de Consulta</label>
            </div>
        </div>
    </div>
    
    {{-- GESTANTE --}}
    <div class="row mb-4">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text custom-group">Gestante</span>
                <select name="gestante" class="form-select">
                    @foreach ($gestantes as $item)
                        <option value="{{$item->id}}" @if($item->id == old('gestante')) selected @endif>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- DATA E HORÁRIO --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-floating mb-4">
                <input
                    type="date"
                    class="form-control"
                    name="data"
                    id="data"
                    value="{{ old('data') }}"
                />
                <label for="data">Data da Consulta</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating mb-4">
                <input
                    type="time"
                    class="form-control"
                    name="horario"
                    id="horario"
                    value="{{ old('horario') }}"
                />
                <label for="horario">Horário</label>
            </div>
        </div>
    </div>

    {{-- BOTÕES --}}
    <div class="row mt-2">
        <div class="col d-flex gap-3">
            <a href="{{route('consulta.index')}}" class="btn btn-custom-back">
                <span class="material-symbols-outlined align-middle">arrow_back</span> Voltar
            </a> 

            <button type="submit" class="btn btn-custom-confirm ms-auto">
                <span class="material-symbols-outlined align-middle">check_circle</span> Confirmar
            </button>
        </div>
    </div>

</form>

</div>

@endsection