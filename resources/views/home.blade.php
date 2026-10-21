@extends('templates/main', [
    'titulo' => "Sistema Pré-Natal",
    'cabecalho' => "",
    'rota' => '',
    'relatorio' => '',
])

@section('conteudo')

<style>
    :root {
        --petroleo: #275553;
        --petroleo-dark: #1b3d3b;
        --petroleo-subtle: #dbe7e5;
        --bg-verde-claro: #eef5f4;
        --bg-verde-card: #e2eceb;
        --border-suave: #c8dad7;
        --texto-main: #183332;
        --texto-muted: #53706e;
    }

    body, .main-content {
        background-color: var(--bg-verde-claro) !important;
    }

    /* Topo do Painel */
    .header-panel {
        background-color: var(--petroleo);
        color: #ffffff;
        border-radius: 12px;
        padding: 24px 28px;
        box-shadow: 0 4px 12px rgba(39, 85, 83, 0.08);
    }

    /* Cards Informativos (KPIs) */
    .stat-card {
        background-color: var(--bg-verde-card);
        border: 1px solid var(--border-suave);
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        transition: border-color 0.2s ease;
    }

    .stat-card:hover {
        border-color: var(--petroleo);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background-color: var(--petroleo);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Bloco do Conteúdo Principal */
    .content-box {
        background-color: var(--bg-verde-card);
        border: 1px solid var(--border-suave);
        border-radius: 12px;
        padding: 24px;
        height: 100%;
    }

    /* Lista da Agenda sem Tabela */
    .agenda-item {
        background-color: #ffffff;
        border: 1px solid var(--border-suave);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .agenda-item:last-child {
        margin-bottom: 0;
    }

    .time-badge {
        background-color: var(--petroleo-subtle);
        color: var(--petroleo-dark);
        font-weight: 700;
        font-size: 1rem;
        padding: 8px 16px;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* Botões de Atalho */
    .btn-shortcut {
        background-color: #ffffff;
        border: 1px solid var(--border-suave);
        color: var(--texto-main);
        font-weight: 600;
        padding: 16px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-shortcut:hover {
        background-color: var(--petroleo);
        color: #ffffff;
        border-color: var(--petroleo);
    }

    .btn-shortcut:hover .shortcut-icon {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    .shortcut-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background-color: var(--petroleo-subtle);
        color: var(--petroleo);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    /* Progresso da Gestante */
    .progress-bar-container {
        height: 12px;
        background-color: var(--petroleo-subtle);
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background-color: var(--petroleo);
        border-radius: 20px;
    }

    .orientacao-container {
        background-color: #ffffff;
        border-left: 4px solid var(--petroleo);
        border-radius: 0 8px 8px 0;
        padding: 18px 20px;
    }
</style>

<div class="container-fluid p-0">

{{-- ========================================================= --}}
{{-- PAINEL DO MÉDICO / COORDENADOR (ROLE 2)                   --}}
{{-- ========================================================= --}}
@if(auth()->user()->role_id == 2)

    {{-- CABEÇALHO DO PAINEL --}}
    <div class="header-panel mb-4">
        <h4 class="fw-bold mb-1">
            Painel Clínico - Dr(a). {{ explode(' ', auth()->user()->name)[0] }}
        </h4>
        <p class="mb-0 text-white-50 small">
            Acompanhamento e gestão de pacientes do programa pré-natal.
        </p>
    </div>

    {{-- INDICADORES --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="d-block text-uppercase fw-bold fs-8" style="color: var(--texto-muted);">Pacientes Ativas</span>
                    <h2 class="fw-bold mb-0" style="color: var(--petroleo);">{{ $totalGestantes ?? 0 }}</h2>
                </div>
                <div class="stat-icon">
                    <span class="material-symbols-outlined fs-3">groups</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="d-block text-uppercase fw-bold fs-8" style="color: var(--texto-muted);">Consultas Agendadas</span>
                    <h2 class="fw-bold mb-0" style="color: var(--petroleo);">{{ $consultasAgendadas ?? 0 }}</h2>
                </div>
                <div class="stat-icon">
                    <span class="material-symbols-outlined fs-3">event</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="d-block text-uppercase fw-bold fs-8" style="color: var(--texto-muted);">Exames Recebidos</span>
                    <h2 class="fw-bold mb-0" style="color: var(--petroleo);">{{ $examesRecebidos ?? 0 }}</h2>
                </div>
                <div class="stat-icon">
                    <span class="material-symbols-outlined fs-3">lab_research</span>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="row g-4">
        
        {{-- AGENDA DO DIA (SEM TABELA, SEM STATUS E SEM AÇÕES) --}}
        <div class="col-12 col-lg-8">
            <div class="content-box">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold mb-0" style="color: var(--texto-main);">Consultas Agendadas para Hoje</h5>
                    <span class="badge" style="background-color: var(--petroleo-subtle); color: var(--petroleo-dark);">
                        {{ isset($consultasHoje) ? count($consultasHoje) : 0 }} horários
                    </span>
                </div>

                @if(isset($consultasHoje) && count($consultasHoje) > 0)
                    @foreach($consultasHoje as $consulta)
                        <div class="agenda-item">
                            <div class="time-badge">
                                {{ \Carbon\Carbon::parse($consulta->horario ?? $consulta->data)->format('H:i') }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: var(--texto-main);">
                                    {{ $consulta->gestante->nome ?? 'Gestante não informada' }}
                                </h6>
                                <small style="color: var(--texto-muted);">
                                    {{ $consulta->gestante->cpf ?? $consulta->gestante->email ?? 'Sem identificação adicional' }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <span class="material-symbols-outlined fs-1 d-block mb-2" style="color: var(--texto-muted);">event_busy</span>
                        <p class="mb-0 fw-semibold" style="color: var(--texto-muted);">Nenhuma consulta agendada para o dia de hoje.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ATALHOS E EXAMES --}}
        <div class="col-12 col-lg-4">
            <div class="d-flex flex-column gap-3 mb-4">
                <h5 class="fw-bold mb-1" style="color: var(--texto-main);">Atalhos Administrativos</h5>
                
                @if(Route::has('consulta.create'))
                    <a href="{{ route('consulta.create') }}" class="btn-shortcut">
                        <div class="d-flex align-items-center gap-3">
                            <div class="shortcut-icon">
                                <span class="material-symbols-outlined fs-5">add</span>
                            </div>
                            <span>Agendar Nova Consulta</span>
                        </div>
                        <span class="material-symbols-outlined fs-5">arrow_forward</span>
                    </a>
                @endif

                @if(Route::has('orientacao.index'))
                    <a href="{{ route('orientacao.index') }}" class="btn-shortcut">
                        <div class="d-flex align-items-center gap-3">
                            <div class="shortcut-icon">
                                <span class="material-symbols-outlined fs-5">chat</span>
                            </div>
                            <span>Central de Orientações</span>
                        </div>
                        <span class="material-symbols-outlined fs-5">arrow_forward</span>
                    </a>
                @endif
            </div>

            <div class="content-box">
                <h6 class="fw-bold mb-3" style="color: var(--texto-main);">Exames Recentes</h6>
                @if(isset($ultimosExames) && count($ultimosExames) > 0)
                    <div class="d-flex flex-column gap-2">
                        @foreach($ultimosExames as $exame)
                            <div class="p-2 border-bottom" style="border-color: var(--border-suave) !important;">
                                <strong class="d-block small" style="color: var(--texto-main);">
                                    {{ $exame->nome ?? $exame->tipo ?? 'Exame' }}
                                </strong>
                                <span class="d-block text-muted" style="font-size: 0.8rem;">
                                    Paciente: {{ $exame->gestante->nome ?? 'N/A' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted small mb-0 py-2">Nenhum exame recente pendente.</p>
                @endif
            </div>
        </div>

    </div>

{{-- ========================================================= --}}
{{-- PAINEL DA GESTANTE                                        --}}
{{-- ========================================================= --}}
@else

    {{-- CABEÇALHO DA GESTANTE --}}
    <div class="header-panel mb-4">
        <h4 class="fw-bold mb-1">
            Área da Paciente - {{ $gestante->nome ?? auth()->user()->name }}
        </h4>
        <p class="mb-0 text-white-50 small">
            Acompanhamento centralizado do pré-natal digital.
        </p>
    </div>

    {{-- INDICADORES DA GESTANTE --}}
    <div class="row g-3 mb-4">
        @if(isset($gestante) && isset($gestante->info_gestacao))
            @php $info = $gestante->info_gestacao; @endphp
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <span class="d-block text-uppercase fw-bold fs-8 mb-1" style="color: var(--texto-muted);">Idade Gestacional</span>
                    <h4 class="fw-bold mb-0" style="color: var(--petroleo);">{{ $info['texto_completo'] ?? '-' }}</h4>
                    <small class="text-muted">{{ $info['trimestre'] ?? '' }}</small>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="stat-card d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-uppercase fw-bold fs-8" style="color: var(--texto-muted);">Progresso</span>
                        <span class="fw-bold" style="color: var(--petroleo);">{{ $info['progresso'] ?? 0 }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $info['progresso'] ?? 0 }}%;"></div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12 col-md-8">
                <div class="stat-card d-flex align-items-center gap-3">
                    <div class="stat-icon">
                        <span class="material-symbols-outlined fs-3">info</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: var(--texto-main);">Dados Gestacionais</h6>
                        <small style="color: var(--texto-muted);">As informações do seu ciclo pré-natal estão em atualização pela equipe.</small>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div>
                    <span class="d-block text-uppercase fw-bold fs-8" style="color: var(--texto-muted);">Exames Solicitados</span>
                    <h2 class="fw-bold mb-0" style="color: var(--petroleo);">{{ $examesPendentes ?? 0 }}</h2>
                </div>
                <div class="stat-icon">
                    <span class="material-symbols-outlined fs-3">clinical_notes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTEÚDO PRINCIPAL DA GESTANTE --}}
    <div class="row g-4 mb-4">
        
        {{-- PRÓXIMA CONSULTA --}}
        <div class="col-12 col-lg-7">
            <div class="content-box">
                <h5 class="fw-bold mb-3" style="color: var(--texto-main);">Próxima Consulta</h5>
                
                @if(isset($proximaConsulta) && $proximaConsulta)
                    <div class="agenda-item mb-0">
                        <div class="time-badge">
                            {{ \Carbon\Carbon::parse($proximaConsulta->data)->format('d/m/Y') }}
                            @if(isset($proximaConsulta->horario))
                                - {{ \Carbon\Carbon::parse($proximaConsulta->horario)->format('H:i') }}
                            @endif
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0" style="color: var(--texto-main);">Consulta Médica de Acompanhamento</h6>
                            @if(!empty($proximaConsulta->observacao))
                                <small class="text-muted d-block mt-1">{{ $proximaConsulta->observacao }}</small>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <span class="material-symbols-outlined fs-1 d-block mb-2" style="color: var(--texto-muted);">event_busy</span>
                        <p class="mb-0 fw-semibold" style="color: var(--texto-muted);">Nenhuma consulta agendada no momento.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ATALHOS DA GESTANTE --}}
        <div class="col-12 col-lg-5">
            <div class="d-flex flex-column gap-3">
                <h5 class="fw-bold mb-1" style="color: var(--texto-main);">Ações Rápidas</h5>

                @if(Route::has('orientacao.index'))
                    <a href="{{ route('orientacao.index') }}" class="btn-shortcut">
                        <div class="d-flex align-items-center gap-3">
                            <div class="shortcut-icon">
                                <span class="material-symbols-outlined fs-5">chat</span>
                            </div>
                            <span>Contato com Equipe Médica</span>
                        </div>
                        <span class="material-symbols-outlined fs-5">arrow_forward</span>
                    </a>
                @endif

                @if(Route::has('exame.index') || Route::has('exames.index'))
                    <a href="{{ Route::has('exame.index') ? route('exame.index') : route('exames.index') }}" class="btn-shortcut">
                        <div class="d-flex align-items-center gap-3">
                            <div class="shortcut-icon">
                                <span class="material-symbols-outlined fs-5">folder</span>
                            </div>
                            <span>Meus Exames</span>
                        </div>
                        <span class="material-symbols-outlined fs-5">arrow_forward</span>
                    </a>
                @endif
            </div>
        </div>

    </div>

    {{-- ÚLTIMA ORIENTAÇÃO --}}
    <div class="row">
        <div class="col-12">
            <div class="content-box">
                <h5 class="fw-bold mb-3" style="color: var(--texto-main);">Última Orientação Médica</h5>
                @if(isset($ultimaOrientacao) && $ultimaOrientacao)
                    <div class="orientacao-container">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong style="color: var(--petroleo);">{{ $ultimaOrientacao->user->name ?? 'Equipe Médica' }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($ultimaOrientacao->created_at)->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-0 text-secondary">
                            {{ $ultimaOrientacao->mensagem ?? $ultimaOrientacao->texto ?? $ultimaOrientacao->descricao }}
                        </p>
                    </div>
                @else
                    <p class="text-muted mb-0">Nenhuma orientação registrada recentemente.</p>
                @endif
            </div>
        </div>
    </div>

@endif

</div>

@endsection