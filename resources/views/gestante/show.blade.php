@extends('templates/main', [
    'titulo' => "Sistema Pre-Natal",
    // Se for o médico (2), mostra 'Dados da Gestante'. Se for ela mesma, mostra 'Meu Perfil'
    'cabecalho' => auth()->check() && auth()->user()->role_id == 2 ? 'Dados da Gestante' : 'Meu Perfil',
    'rota' => '',       
    'relatorio' => '',  
    'class' => App\Models\Gestante::class,
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

/* CARD GLASS */
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

/* CAIXINHAS DE INFORMAÇÃO */
.info-box {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(39, 85, 83, 0.05);
    border: 1px solid rgba(255,255,255,0.5);
    transition: 0.3s ease;
    height: calc(100% - 20px); 
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

/* FOTO DE PERFIL */
.foto-perfil {
    width: 130px;
    height: 130px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid var(--green);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.foto-placeholder {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    border: 4px solid var(--green);
    background: rgba(255,255,255,0.65);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* BOTÃO CUSTOMIZADO DE VOLTAR */
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
    
    {{-- CABEÇALHO: FOTO E NOME LADO A LADO --}}
    <div class="d-flex flex-column flex-md-row align-items-center gap-4 mb-4">
        @if($gestante->foto)
            <img src="{{ asset('storage/'.$gestante->foto) }}" alt="Foto" class="foto-perfil">
        @else
            <div class="foto-placeholder">
                <span class="material-symbols-outlined text-secondary" style="font-size: 60px;">person</span>
            </div>
        @endif
        
        <h4 class="texto-info mb-0 text-center text-md-start" style="font-size: 2rem;">{{ $gestante->nome }}</h4>
    </div>

    <hr class="my-4" style="border-color: rgba(39, 85, 83, 0.2)">
    
    {{-- GRID ÚNICO COM TODAS AS INFORMAÇÕES --}}
    <div class="row">
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-label">Email</span>
                <div class="info-value">{{ $gestante->email ?? 'Não informado' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-label">Telefone</span>
                <div class="info-value">{{ $gestante->telefone ?? 'Não informado' }}</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">CPF</span>
                <div class="info-value">{{ $gestante->cpf ?? 'Não informado' }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Data de Nascimento</span>
                <div class="info-value">
                    {{ $gestante->data_nascimento ? \Carbon\Carbon::parse($gestante->data_nascimento)->format('d/m/Y') : 'Não informada' }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-label">Estado Civil</span>
                <div class="info-value">{{ $gestante->estado_civil ?? 'Não informado' }}</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <span class="info-label">Altura</span>
                <div class="info-value">{{ $gestante->altura ? number_format($gestante->altura, 2, ',', '.') . ' m' : 'Não informada' }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-label">Peso Atual</span>
                <div class="info-value">{{ $gestante->peso_atual ? number_format($gestante->peso_atual, 2, ',', '.') . ' kg' : 'Não informado' }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-label">DUM (Última Menstruação)</span>
                <div class="info-value">
                    {{ $gestante->dum ? \Carbon\Carbon::parse($gestante->dum)->format('d/m/Y') : 'Não informada' }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-label">Data Provável do Parto</span>
                <div class="info-value">
                    {{ $gestante->info_gestacao['dpp'] ?? 'Não calculada' }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-label">Idade Gestacional</span>
                <div class="info-value">
                    {{ $gestante->info_gestacao['texto_completo'] ?? 'Não calculada' }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-label">Trimestre</span>
                <div class="info-value">
                    {{ $gestante->info_gestacao['trimestre'] ?? 'Não informado' }}
                </div>
            </div>
        </div>
        

    {{-- MOTIVO DE ARQUIVAMENTO (Caso o acesso venha da aba de arquivadas, a justificativa continua aparecendo) --}}
    @if($gestante->status === 'Arquivada')
        <div class="row mt-2">
            <div class="col-12">
                <div class="info-box" style="border: 1px solid rgba(230, 57, 70, 0.3); background: rgba(230, 57, 70, 0.05);">
                    <span class="info-label" style="color: var(--danger) !important;">Motivo do Arquivamento</span>
                    <div class="info-value" style="color: var(--danger);">{{ $gestante->motivo_arquivamento ?? 'Nenhum motivo registrado.' }}</div>
                </div>
            </div>
        </div>
    @endif

    {{-- BOTÃO VOLTAR (Aparece apenas para Médico/Coordenador - role_id 2) --}}
    @if(auth()->check() && auth()->user()->role_id == 2)
        <div class="row mt-4">
            <div class="col">
                <a href="{{ route('gestante.index') }}" class="btn btn-custom-back">
                    <span class="material-symbols-outlined align-middle">arrow_back</span> Voltar para a Lista
                </a>
            </div>
        </div>
    @endif
</div>

@endsection