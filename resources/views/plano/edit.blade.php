@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Alterar Gestante',
    'rota' => '',
    'relatorio' => '',
])
@section('conteudo')

<style>
:root{
    --green: #41d97b;
    --green-strong: #2fbe66;
    --green-light: #7fffc0;
    --danger: #ff5c5c;
}

/* FUNDO */
body {
    background: linear-gradient(135deg, #b2ffd6 0%, #4ccf8a 50%, #239864 100%);
    min-height: 100vh;
    padding: 22px;
    overflow: auto; /* permite rolagem */
    color: #fff;
}

/* PARTICULAS NUTRICIONAIS FLUTUANDO */
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
    box-shadow: 0 0 12px rgba(65,217,123,0.35);
    color: #222;
}

/* LABEL */
.form-floating label {
    color: #0a6c43 !important;
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
    box-shadow: 0 0 10px rgba(65,217,123,0.28);
}

.btn-custom-confirm:hover {
    background: var(--green-strong);
    box-shadow: 0 0 18px rgba(65,217,123,0.45);
}

/* RESPONSIVO */
@media (max-width: 576px) {
    .form-card { padding: 18px; }
    .btn-custom-back, .btn-custom-confirm { width: 100%; margin-bottom: 10px; }
}
</style>

{{-- PARTICULAS --}}
@php
$icons = ['🍼'];
$quantidade = 18;
@endphp
@for ($i = 0; $i < $quantidade; $i++)
    @php
        $emoji = $icons[array_rand($icons)];
        $left = rand(2, 95);
        $delay = -($i * 0.7);
        $size = rand(20, 34);
    @endphp
    <div class="nutri" style="left: {{ $left }}%; font-size: {{ $size }}px; animation-delay: {{ $delay }}s;">
        {{ $emoji }}
    </div>
@endfor

{{-- FORMULÁRIO --}}
<div class="form-card">
<form action="{{route('plano.update', $plano->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- NOME --}}
    <div class="row mb-3">
        <div class="col">
            <div class="form-floating">
                <input type="text" class="form-control" name="nome" placeholder="Nome" value="{{ $plano->nome }}"/>
                <label for="nome">Nome</label>
            </div>
        </div>
    </div>

    {{-- GESTANTE --}}
    <div class="row mb-3">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text bg-secondary text-white">Gestante</span>
                <select name="gestante" class="form-select form-control">
                    @foreach ($gestantes as $item)
                        <option value="{{$item->id}}" @if($item->id == $plano->gestante_id) selected @endif>
                            {{ $item->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- KCAL E REF --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="number" class="form-control" name="kcal_dia" placeholder="Calorias" value="{{ $plano->kcal_dia }}"/>
                <label for="kcal_dia">Calorias por dia</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="number" class="form-control" name="ref_dia" placeholder="Refeicoes" value="{{ $plano->ref_dia }}"/>
                <label for="ref_dia">Refeições por dia</label>
            </div>
        </div>
    </div>

    {{-- OBSERVACOES --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" name="observacoes" placeholder="Observacoes" value="{{ $plano->observacoes }}"/>
                <label for="observacoes">Observações</label>
            </div>
        </div>
    </div>

    {{-- BOTÕES --}}
    <div class="row mt-4">
        <div class="col d-flex gap-3">
            <a href="{{route('plano.index')}}" class="btn btn-custom-back">⬅️ Voltar</a>
            <button type="submit" class="btn btn-custom-confirm ms-auto">✔️ Confirmar</button>
        </div>
    </div>

</form>
</div>

@endsection
