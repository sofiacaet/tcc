@extends('templates/main', [
    'titulo' => "Sistema Pre-Natal",
    'cabecalho' => 'Lista de Gestantes',
    'rota' => '',       
    'relatorio' => '',  
    'class' => App\Models\Gestante::class,
])

@section('conteudo')

<style>
:root{
    --green: #2b7a78;         
    --green-strong: #1d5250;  
    --green-light: #489996;   
    --danger: #e63946;        
}

body {
    background-color: #c5dede;
    min-height: 100vh;
    padding: 22px;
    overflow: auto;
    color: #275553; 
}

.btn-action-top {
    backdrop-filter: blur(10px);
    border-radius: 14px;
    padding: 12px 26px;
    font-size: 0.95rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.btn-print-top {
    background: var(--green);
    border: 2px solid var(--green);
    color: #fff;
}
.btn-print-top:hover {
    background: var(--green-strong);
    border-color: var(--green-strong);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.table-wrapper {
    margin-top: 18px;
    background: rgba(255,255,255,0.16);
    backdrop-filter: blur(14px);
    padding: 22px;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22);
    overflow: hidden;
}

table.modern-table {
    width: 100%;
    max-width: 100%;
    border-radius: 12px;
    border-collapse: separate;
    overflow: hidden;
}

table.modern-table thead tr {
    background: linear-gradient(90deg, var(--green), var(--green-light));
    color: #fff;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
}

table.modern-table th {
    text-align: center !important;
}

table.modern-table tbody tr {
    background: rgba(255,255,255,0.18);
    transition: background 0.2s ease;
}

table.modern-table tbody tr:hover {
    background: rgba(255,255,255,0.35);
}

td, th {
    padding: 14px 18px !important;
}

.btn-status-dropdown {
    border: 2px solid var(--green-strong);
    color: var(--green-strong);
    background: transparent;
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
}
.btn-status-dropdown:hover, .btn-status-dropdown:focus { 
    background: var(--green-strong); 
    color: #fff; 
}

.btn-actions-menu {
    border: 2px solid var(--green);
    color: var(--green);
    background: transparent;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s;
}
.btn-actions-menu:hover, .btn-actions-menu:focus {
    background: var(--green);
    color: #fff;
}
.btn-actions-menu::after {
    display: none;
}

.dropdown {
    position: relative !important;
}

.nav-tabs .nav-link {
    color: #275553 !important;
    font-weight: 500;
}
</style>

{{-- Grupo de Botões Alinhados à Direita --}}
<div class="d-flex justify-content-end gap-3 mb-3">
    <a href="{{ route('report.gestante') }}" class="btn-action-top btn-print-top" target="_blank">
        <span class="material-symbols-outlined">print</span>
        Imprimir Relatório
    </a>

    @can('create', App\Models\Gestante::class)
        <a href="{{ route('gestante.create') }}" class="btn-action-top btn-print-top">
            <span class="material-symbols-outlined">person_add</span>
            Nova Gestante
        </a>
    @endcan
</div>

{{-- CARD PRINCIPAL --}}
<div class="table-wrapper">

    {{-- Menu de Abas (Apenas 2 Status) --}}
    <ul class="nav nav-tabs mb-4" id="gestanteTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="acompanhamento-tab" data-bs-toggle="tab" data-bs-target="#acompanhamento" type="button" role="tab">
                Em Acompanhamento
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="arquivada-tab" data-bs-toggle="tab" data-bs-target="#arquivada" type="button" role="tab">
                Arquivadas
            </button>
        </li>
    </ul>

    <div class="tab-content" id="gestanteTabsContent">
        
        {{-- ABA 1: EM ACOMPANHAMENTO --}}
        <div class="tab-pane fade show active" id="acompanhamento" role="tabpanel">
            <table class="modern-table table align-middle">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th class="d-none d-md-table-cell">EMAIL</th>
                        <th class="d-none d-md-table-cell">TELEFONE</th>
                        <th class="d-none d-md-table-cell">CPF</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gestantes->where('status', 'Em acompanhamento') as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->nome }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->email }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->telefone }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->cpf }}</td>
                            
                            <td class="text-center text-nowrap">
                                @can('update', $item)
                                    {{-- Botão para Arquivar (Abre Modal de Motivo) --}}
                                    <button class="btn btn-status-dropdown" data-bs-toggle="modal" data-bs-target="#modalArquivar{{ $item->id }}" title="Arquivar Gestante">
                                        <span class="material-symbols-outlined align-middle">archive</span> 
                                    </button>
                                @endcan
                                    <a class="btn btn-status-dropdown"  href="{{ route('gestante.show', $item->id) }}">
                                        <span class="material-symbols-outlined align-middle">visibility</span> Detalhar 
                                    </a>
                                    
                                    @can('update', $item)
                                        <a class="btn btn-status-dropdown"  href="{{ route('gestante.edit', $item->id) }}">
                                            <span class="material-symbols-outlined align-middle">edit</span> Editar
                                        </a>
                                    @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted fw-bold">Nenhuma gestante em acompanhamento no momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ABA 2: ARQUIVADAS --}}
        <div class="tab-pane fade" id="arquivada" role="tabpanel">
            <table class="modern-table table align-middle">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th class="d-none d-md-table-cell">MOTIVO DO ARQUIVAMENTO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gestantes->where('status', 'Arquivada') as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->nome }}</td>
                            <td class="d-none d-md-table-cell text-muted">{{ $item->motivo_arquivamento ?? 'Não informado' }}</td>
                            <td class="text-center text-nowrap">
                                @can('update', $item)
                                    {{-- Botão para Reativar (Voltar para Em Acompanhamento) --}}
                                    <form action="{{ route('gestante.status', $item->id) }}" method="POST" class="d-inline-block me-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Em acompanhamento">
                                        <button type="submit" class="btn btn-status-dropdown" title="Reativar Acompanhamento">
                                            <span class="material-symbols-outlined align-middle">unarchive</span> Reativar
                                        </button>
                                    </form>
                                @endcan

                                <a class="btn btn-status-dropdown" href="{{ route('gestante.show', $item->id) }}">
                                    <span class="material-symbols-outlined align-middle">visibility</span> Detalhar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted fw-bold">Nenhuma gestante arquivada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- =========================================================================
     MODAIS DEVEM FICAR AQUI (FORA DA TABELA E FORA DA DIV COM BACKDROP FILTER)
     ========================================================================= --}}
@foreach ($gestantes->where('status', 'Em acompanhamento') as $item)
    <div class="modal fade" id="modalArquivar{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; background: #f4fbfb;">
                <form action="{{ route('gestante.status', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Arquivada">
                    
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-dark">Arquivar Gestante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-3">Informe o motivo do arquivamento para a paciente <strong>{{ $item->nome }}</strong>:</p>
                        <div class="mb-3">
                            <textarea name="motivo_arquivamento" class="form-control" rows="3" required placeholder="Digite o motivo aqui..." style="border-radius: 10px; border: 1px solid #2b7a78;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4" style="background-color: var(--danger); border: none;">Confirmar Arquivamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection