@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Lista de Consultas',
    'rota' => '',       // Esconde o botão de "+" padrão
    'relatorio' => '',   // Esconde o botão da impressora padrão lá de cima
    'class' => App\Models\Consulta::class,
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
    overflow: auto;
    color: #275553; 
}

/* NOVOS BOTÕES SUPERIORES MODERNOS */
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

/* Estilo específico do Imprimir (Glass Clean) */
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



/* CARD GLASS */
.table-wrapper {
    margin-top: 18px;
    background: rgba(255,255,255,0.16);
    backdrop-filter: blur(14px);
    padding: 22px;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.22);
}

/* TABELA */
table.modern-table {
    width: 100%;
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
    background: rgba(255,255,255,0.35);
}

td, th {
    padding: 14px 18px !important;
}

/* BOTÕES */
.btn-edit {
    border: 2px solid var(--green);
    color: var(--green);
    background: transparent;
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
}

.btn-edit:hover,
.btn-edit:focus,
.btn-edit:active { 
    background-color: var(--green-strong) !important; 
    border-color: var(--green-strong) !important;
    color: #fff !important; 
    transform: translateY(-2px);
}

.btn-delete {
    border: 2px solid var(--danger);
    color: var(--danger);
    background: transparent;
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
}

.btn-delete:hover,
.btn-delete:focus,
.btn-delete:active { 
    background-color: var(--danger) !important; 
    border-color: var(--danger) !important;
    color: #fff !important; 
    transform: translateY(-2px);
}

.nav-tabs .nav-link {
    color: #275553 !important;
    font-weight: 500;
}

</style>


{{-- Grupo de Botões Alinhados à Direita (Design Atualizado) --}}
<div class="d-flex justify-content-end gap-3 mb-3">
    
    {{-- Botão de Impressão --}}
    <a href="{{ route('report.consulta') }}" class="btn-action-top btn-print-top" target="_blank">
        <span class="material-symbols-outlined">print</span>
        Imprimir Relatório
    </a>

    {{-- Botão de Agendar Consulta --}}
    @can('create', App\Models\Consulta::class)
        <a href="{{ route('consulta.create') }}" class="btn-action-top btn-print-top">
            <span class="material-symbols-outlined">calendar_month</span>
            Agendar Consulta
        </a>
    @endcan
    
</div>

{{-- CARD PRINCIPAL --}}
<div class="table-wrapper">

    
   {{-- Menu de Abas --}}
    <ul class="nav nav-tabs mb-4" id="consultaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="agendadas-tab" data-bs-toggle="tab" data-bs-target="#agendadas" type="button" role="tab">
                Consultas Agendadas
            </button>
        </li>
        {{-- ALTERAÇÃO AQUI: Apenas o Médico / Coordenador (role_id 2) verá a aba de Realizadas --}}
        @if(auth()->user()->role_id == 2)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="realizadas-tab" data-bs-toggle="tab" data-bs-target="#realizadas" type="button" role="tab">
                    Histórico de Realizadas
                </button>
            </li>
        @endif
    </ul>

    {{-- Conteúdo das Abas --}}
    <div class="tab-content" id="consultaTabsContent">
        
        {{-- ABA 1: CONSULTAS AGENDADAS --}}
        <div class="tab-pane fade show active" id="agendadas" role="tabpanel">
            <table class="modern-table table align-middle">
                <thead>
                    <tr>
                        <th>CONSULTA</th>
                        <th class="d-none d-md-table-cell">GESTANTE</th>
                        <th class="d-none d-md-table-cell">LOCAL</th>
                        <th class="d-none d-md-table-cell">DATA/HORA</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agendadas as $item)
                        <tr>
                            <td>{{ $item->tipo_consulta }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->gestante->nome }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->local ?? 'Não informado' }}</td>
                            <td class="d-none d-md-table-cell">
                                {{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($item->horario)->format('H:i') }}
                            </td>
                            <td class="text-nowrap">
                                @can('update', $item)
                                    <a href="{{ route('consulta.edit', $item->id) }}" class="btn btn-edit me-2">
                                        <span class="material-symbols-outlined align-middle">clinical_notes</span>
                                        Registrar
                                    </a>
                                @endcan
                                
                                @can('delete', $item)
                                    <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item->id }}', '{{ $item->tipo_consulta }} - {{ $item->gestante->nome }}')" class="btn btn-delete"> 
                                        <span class="material-symbols-outlined align-middle">delete</span> 
                                        Excluir
                                    </a>
                                    <form action="{{route('consulta.destroy', $item->id)}}" method="POST" id="form_{{$item->id}}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-white-50">Nenhuma consulta agendada no momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(auth()->user()->role_id == 2)
            {{-- ABA 2: HISTÓRICO DE REALIZADAS --}}
            <div class="tab-pane fade" id="realizadas" role="tabpanel">
                <table class="modern-table table align-middle">
                    <thead>
                        <tr>
                            <th>CONSULTA</th>
                            <th>GESTANTE</th>
                            <th class="d-none d-md-table-cell">LOCAL</th>
                            <th class="d-none d-md-table-cell">DATA/HORA</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($realizadas as $item)
                            <tr>
                                <td>{{ $item->tipo_consulta }}</td>
                                <td>{{ $item->gestante->nome }}</td>
                                <td class="d-none d-md-table-cell">{{ $item->local ?? 'Não informado' }}</td>
                                <td class="d-none d-md-table-cell">
                                    {{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($item->horario)->format('H:i') }}
                                </td>
                                
                                <td class="text-nowrap">
                                    <a href="{{ route('consulta.show', $item->id) }}" class="btn btn-edit me-2">
                                        <span class="material-symbols-outlined align-middle">visibility</span> 
                                        Detalhar
                                    </a>
                                    @can('delete', $item)
                                        <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item->id }}', '{{ $item->tipo_consulta }} - {{ $item->gestante->nome }}')" class="btn btn-delete"> 
                                            <span class="material-symbols-outlined align-middle">delete</span> 
                                            Excluir
                                        </a>
                                        <form action="{{route('consulta.destroy', $item->id)}}" method="POST" id="form_{{$item->id}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-white-50">Nenhuma consulta realizada no histórico.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>

@endsection
