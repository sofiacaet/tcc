@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Nova Gestante',
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

/* FUNDO */
body {
    background-color: #c5dede;
    min-height: 100vh;
    padding: 22px;
    overflow: auto; /* permite rolagem */
    color: #275553; 
}

/* CARD GLASS */
.form-card {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(14px);
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(39, 85, 83, 0.15);
    margin-top: 18px;
    border: 1px solid rgba(255, 255, 255, 0.4);
}

/* INPUTS ADAPTADOS PARA O TEMA CLARO */
.form-floating > .form-control, 
.form-select,
input[type="file"].form-control {
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
.form-select:focus,
input[type="file"].form-control:focus {
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

/* ESTILIZAÇÃO DO INPUT GROUP (Foto) */
.input-group-text.custom-group {
    background: linear-gradient(90deg, var(--green), var(--green-light));
    color: #fff;
    border: none;
    border-radius: 12px 0 0 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.input-group > .form-control[type="file"] {
    border-radius: 0 12px 12px 0 !important;
    padding-top: 10px; /* Ajuste fino para alinhar o texto do input file */
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
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-custom-confirm:hover {
    background: var(--green-strong);
    border-color: var(--green-strong);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(29, 82, 80, 0.3);
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

{{-- FORMULÁRIO --}}
<div class="form-card">
<form action="{{route('gestante.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- FOTO --}}
    <div class="row mb-4">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text custom-group">Foto</span>
                <input class="form-control" type="file" name="foto"/>
            </div>
        </div>
    </div>

    {{-- NOME, ALTURA E PESO --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="form-floating mb-3 mb-md-0">
                <input type="text" class="form-control" name="nome" placeholder="Nome" value="{{ old('nome') }}"/>
                <label for="nome">Nome</label>
            </div>
        </div>
         <div class="col-md-2">
            <div class="form-floating mb-3 mb-md-0">
                <input type="number" step="0.01" class="form-control" name="altura" placeholder="Altura" value="{{ old('altura') }}"/>
                <label for="altura">Altura (m)</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating mb-3 mb-md-0">
                <input type="number" step="0.01" class="form-control" name="peso_atual" placeholder="Peso Atual" value="{{ old('peso_atual') }}"/>
                <label for="peso_atual">Peso Atual (kg)</label>
            </div>
        </div>
    </div>

    {{-- EMAIL E TELEFONE --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}"/>
                <label for="email">E-mail</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input type="text" class="form-control" name="telefone" placeholder="Telefone" value="{{ old('telefone') }}"/>
                <label for="telefone">Telefone</label>
            </div>
        </div>
    </div>

    {{-- DATA DE NASCIMENTO,  CPF E ESTADO CIVIL --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-floating mb-3 mb-md-0">
                <input type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}">
                <label for="data_nascimento">Data de Nascimento</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-floating mb-3 mb-md-0">
                <input type="text" class="form-control" name="cpf" placeholder="CPF" value="{{ old('cpf') }}">
                <label for="cpf">CPF</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-floating">
                <select class="form-select" name="estado_civil">
                    <option value="">Selecione</option>
                    <option value="Solteira" {{ old('estado_civil') == 'Solteira' ? 'selected' : '' }}>Solteira</option>
                    <option value="Casada" {{ old('estado_civil') == 'Casada' ? 'selected' : '' }}>Casada</option>
                    <option value="União Estável" {{ old('estado_civil') == 'União Estável' ? 'selected' : '' }}>União Estável</option>
                    <option value="Divorciada" {{ old('estado_civil') == 'Divorciada' ? 'selected' : '' }}>Divorciada</option>
                    <option value="Viúva" {{ old('estado_civil') == 'Viúva' ? 'selected' : '' }}>Viúva</option>
                </select>
                <label for="estado_civil">Estado Civil</label>
            </div>
        </div>
    </div>

    {{-- BOTÕES --}}
    <div class="row mt-2">
        <div class="col d-flex flex-wrap gap-3">
            <a href="{{route('gestante.index')}}" class="btn btn-custom-back">
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