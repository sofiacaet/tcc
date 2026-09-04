@extends('templates/main', [
    'titulo' => "Sistema Pre-Natal",
    'cabecalho' => 'Lista de Exames',
    'rota' => '',       // Esconde o botão de "+" padrão para usar o superior personalizado
    'relatorio' => '',  // Esconde o relatório padrão para usar o superior personalizado
    'class' => App\Models\Exame::class,
])

@section('conteudo')

<style>
:root {
    --green: #4197d9;
    --green-strong: #70a1de;
    --green-light: #195a71;
    --danger: #ff5c5c;
}

/* FUNDO */
body {
    background-color: #c5dede;
    min-height: 100vh;
    padding: 22px;
    overflow: hidden;
    color: #275553; 
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
    0% { transform: translateY(110vh) rotate(0deg) scale(0.9); opacity: .25; }
    40% { opacity: 1; }
    100% { transform: translateY(-20vh) rotate(360deg) scale(1.2); opacity: 0; }
}

/* BOTÕES SUPERIORES MODERNOS */
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
    background: rgba(255, 255, 255, 0.12);
    border: 2px solid rgba(255, 255, 255, 0.25);
    color: #fff;
}
.btn-print-top:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

/* CARD GLASS */
.table-wrapper {
    margin-top: 18px;
    background: rgba(255,255,255,0.16);
    backdrop-filter: blur(14px);
    padding: 22px;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22);
    overflow-x: auto;
}

/* TABELA */
table.modern-table {
    width: 100%;
    max-width: 100%;
    border-radius: 12px;
    overflow: hidden;
    border-collapse: separate;
}

table.modern-table thead tr {
    background: linear-gradient(90deg, var(--green), var(--green-light));
    color: #fff;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
}

table.modern-table tbody tr {
    background: rgba(255,255,255,0.18);
    transition: .28s ease;
}

table.modern-table tbody tr:hover {
    transform: translateY(-4px) scale(1.01);
    background: rgba(255,255,255,0.34);
    box-shadow: 0 10px 30px rgba(0,0,0,0.18), 0 0 12px rgb(88, 185, 254) inset;
}

td, th {
    padding: 14px 18px !important;
}

/* BOTÕES DE AÇÃO NA TABELA */
.btn-edit {
    border: 2px solid #7fffc0;
    color: #7fffc0;
    background: transparent;
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
    text-decoration: none;
}
.btn-edit:hover { background: var(--green); color: #fff; }

.btn-upload {
    border: 2px solid #195a71;
    color: #195a71;
    background: rgba(255,255,255,0.15);
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
}
.btn-upload:hover { background: #195a71; color: #ffffff; }

.btn-delete {
    border: 2px solid var(--danger);
    color: var(--danger);
    background: transparent;
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
}
.btn-delete:hover { background: var(--danger); color: #fff; }

/* MODAL DE UPLOAD DE DOCUMENTO */
.modal-content {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    color: #333;
}

/* CORREÇÃO DO MODAL */
.modal {
    z-index: 1060 !important;
}
.modal-backdrop {
    z-index: 1050 !important;
}
</style>

{{-- Grupo de Botões Alinhados à Direita --}}
<div class="d-flex justify-content-end gap-3 mb-3">
    
    {{-- Botão de Impressão --}}
    <a href="{{ route('report.exame') }}" class="btn-action-top btn-print-top" target="_blank">
        <span class="material-symbols-outlined">print</span>
        Imprimir Relatório
    </a>

    {{-- Botão de Solicitar Exame --}}
    @can('create', App\Models\Exame::class)
        <a href="{{ route('exame.create') }}" class="btn-action-top btn-print-top">
            <span class="material-symbols-outlined">add_notes</span>
            Solicitar Exame
        </a>
    @endcan
    
</div>

{{-- CARD PRINCIPAL --}}
<div class="table-wrapper">

    {{-- Menu de Abas --}}
    <ul class="nav nav-tabs mb-4" id="exameTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="solicitados-tab" data-bs-toggle="tab" data-bs-target="#solicitados" type="button" role="tab">
                Exames Solicitados
            </button>
        </li>
        
        {{-- Apenas o Médico / Coordenador (role_id 2) verá a aba de Recebidos --}}
        @if(auth()->user()->role_id == 2)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="recebidos-tab" data-bs-toggle="tab" data-bs-target="#recebidos" type="button" role="tab">
                    Histórico de Recebidos
                </button>
            </li>
        @endif
    </ul>

    {{-- Conteúdo das Abas --}}
    <div class="tab-content" id="exameTabsContent">
        
        {{-- ABA 1: EXAMES SOLICITADOS --}}
        <div class="tab-pane fade show active" id="solicitados" role="tabpanel">
            <table class="modern-table table align-middle">
                <thead>
                    <tr>
                        <th>EXAME</th>
                        <th class="d-none d-md-table-cell">NOME DA GESTANTE</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($solicitados as $item)
                        <tr>
                            <td>{{ $item->tipo_exame }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->gestante->nome }}</td>
                            <td class="text-nowrap">
                                @if(auth()->user()->role_id != 2)
                                    {{-- Anexar Documento (Abre Modal) --}}
                                    <button type="button" class="btn btn-upload me-2" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $item->id }}">
                                        <span class="material-symbols-outlined align-middle">upload_file</span> 
                                        Anexar
                                    </button>
                                @endif

                                @can('update', $item)
                                    <a href="{{ route('exame.edit', $item->id) }}" class="btn btn-edit me-2">
                                        <span class="material-symbols-outlined align-middle">edit</span>
                                        Editar
                                    </a>
                                @endcan
                                
                                @can('delete', $item)
                                    <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item->id }}', '{{ $item->tipo_exame }} - {{ $item->gestante->nome }}')" class="btn btn-delete"> 
                                        <span class="material-symbols-outlined align-middle">delete</span> 
                                        Excluir
                                    </a>
                                    <form action="{{ route('exame.destroy', $item->id) }}" method="POST" id="form_{{ $item->id }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-white-50">Nenhum exame solicitado no momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ABA 2: HISTÓRICO DE RECEBIDOS --}}
        @if(auth()->user()->role_id == 2)
        <div class="tab-pane fade" id="recebidos" role="tabpanel">
            <table class="modern-table table align-middle">
                <thead>
                    <tr>
                        <th>EXAME</th>
                        <th class="d-none d-md-table-cell">NOME DA GESTANTE</th>
                        <th>DOCUMENTO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recebidos as $item)
                        <tr>
                            <td>{{ $item->tipo_exame }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->gestante->nome }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $item->documento) }}" target="_blank" class="btn btn-edit">
                                    <span class="material-symbols-outlined align-middle">visibility</span> 
                                    Ver Arquivo
                                </a>
                            </td>
                            <td class="text-nowrap">
                                @can('delete', $item)
                                    <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item->id }}', '{{ $item->tipo_exame }} - {{ $item->gestante->nome }}')" class="btn btn-delete"> 
                                        <span class="material-symbols-outlined align-middle">delete</span> 
                                        Excluir
                                    </a>
                                    <form action="{{ route('exame.destroy', $item->id) }}" method="POST" id="form_{{ $item->id }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-white-50">Nenhum exame recebido até o momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div> {{-- FIM DO TABLE-WRAPPER --}}


{{-- MODAIS RENDERIZADOS FORA DO CARD (RESOLVE O PROBLEMA DE CLIQUE) --}}
@if(auth()->user()->role_id != 2)
    @foreach ($solicitados as $item)
        <div class="modal fade" id="uploadModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold" style="color: #195a71;">
                            Anexar Resultado de Exame
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('exame.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <p class="text-muted small mb-3">Selecione o arquivo do exame (imagem ou PDF) para enviar:</p>
                            <div class="input-group">
                                <input type="file" class="form-control" name="documento" required>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" style="background-color: var(--green); border: none;">Confirmar Envio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif

@endsection