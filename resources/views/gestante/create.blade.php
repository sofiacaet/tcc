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
    --green: #4197d9;
    --green-strong: #70a1de;
    --green-light: #7fffc0;
    --danger: #ff5c5c;
}

/* FUNDO */
body {
    background: linear-gradient(135deg, #75c8ff 0%, #4dabf8 50%, #193b68 100%);
    min-height: 100vh;
    padding: 22px;
    overflow: auto; /* permite rolagem */
    color: #fff;
}

/* PARTICULAS NUTRICIONAIS */
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
    background: rgba(255, 255, 255, 0.90) !important;
    border: 2px solid transparent;
    color: #333;
    border-radius: 12px !important;
    transition: .25s;
    font-weight: 600;
}

.form-floating .form-control::placeholder { color: #666 !important; }

.form-floating > .form-control:focus {
    border-color: var(--green-light);
    background: rgba(255,255,255,1) !important;
    box-shadow: 0 0 12px rgb(88, 185, 254);
    color: #222;
}

/* LABEL */
.form-floating label {
    color: #1973af !important;
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

.btn-custom-back:hover { background: rgba(255,255,255,0.30); }

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

/* RESPONSIVO */
@media (max-width: 576px) {
    .form-card { padding: 18px; }
    .btn-custom-back, .btn-custom-confirm { width: 100%; margin-bottom: 10px; }
}
</style>



{{-- FORMULÁRIO --}}
<div class="form-card">
<form action="{{route('gestante.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- FOTO --}}
    <div class="row mb-3">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text bg-secondary text-white">Foto</span>
                <input class="form-control text-secondary" type="file" name="foto"/>
            </div>
        </div>
    </div>

    {{-- NOME, ALTURA E PESO --}}
    <div class="row mb-3">
        <div class="col">
            <div class="form-floating">
                <input type="text" class="form-control" name="nome" placeholder="Nome" value="{{ old('nome') }}"/>
                <label for="nome">Nome</label>
            </div>
        </div>
         <div class="col-md-2">
            <div class="form-floating">
                <input type="number" step="0.01" class="form-control" name="altura" placeholder="Altura" value="{{ old('altura') }}"/>
                <label for="altura">Altura</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating">
                <input type="number" step="0.01" class="form-control" name="peso_atual" placeholder="Peso Atual" value="{{ old('peso_atual') }}"/>
                <label for="peso_atual">Peso Atual</label>
            </div>
        </div>
    </div>

    {{-- EMAIL E TELEFONE --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}"/>
                <label for="email">E-mail</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" name="telefone" placeholder="Telefone" value="{{ old('telefone') }}"/>
                <label for="telefone">Telefone</label>
            </div>
        </div>
    </div>

    {{-- DATA DE NASCIMENTO,  CPF E ESTADO CIVIL --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="date" class="form-control" name="data_nascimento" value="{{ old('data_nascimento') }}">
                <label for="data_nascimento">Data de Nascimento</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-floating">
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
    <div class="row mt-4">
        <div class="col d-flex gap-3">
            <a href="{{route('gestante.index')}}" class="btn btn-custom-back">⬅️ Voltar</a>
            <button type="submit" class="btn btn-custom-confirm ms-auto">✔️ Confirmar</button>
        </div>
    </div>

</form>
</div>

@endsection
