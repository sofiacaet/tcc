@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Lista de Consultas',
    'rota' => 'consulta.create',
    'relatorio' => 'report.consulta',
    'class' => App\Models\Consulta::class,
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
    overflow: auto;
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

/* animação geral */
@keyframes floatNutri {
    0% { transform: translateY(110vh) rotate(0deg) scale(0.9); opacity: .25; }
    40% { opacity: 1; }
    100% { transform: translateY(-20vh) rotate(360deg) scale(1.2); opacity: 0; }
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
    transform: translateY(-4px) scale(1.01);
    background: rgba(255,255,255,0.34);
    box-shadow: 0 10px 30px rgba(0,0,0,0.18), 0 0 12px rgb(88, 185, 254) inset;
}

td, th {
    padding: 14px 18px !important;
}

/* BOTÕES */
.btn-edit {
    border: 2px solid var(--green-light);
    color: var(--green-light);
    background: transparent;
    border-radius: 28px;
    padding: 6px 14px;
    font-weight: 700;
    transition: .2s;
}

.btn-edit:hover { background: var(--green); color: #fff; }

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

</style>




{{-- CARD PRINCIPAL --}}
<div class="table-wrapper">

    <table class="modern-table table align-middle">
        <thead>
            <tr>
                <th>CONSULTA</th>
                <th class="d-none d-md-table-cell">NOME DA GESTANTE</th>
                <th class="d-none d-md-table-cell">DATA</th>
                <th class="d-none d-md-table-cell">HORÁRIO</th>
                <th class="d-none d-md-table-cell">INSTRUÇÕES</th>
                <th>AÇÕES</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($consultas as $item)
                <tr>
                    <td>{{ $item->tipo_consulta }}</td>
                    <td class="d-none d-md-table-cell">{{ $item->gestante->nome }}</td>
                    <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}</td>
                    <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($item->horario)->format('H:i') }}</td>
                    <td class="d-none d-md-table-cell">{{ $item->instrucao }}</td>

                    <td class="text-nowrap">

                         @can('update', $item)
                            <a href="{{ route('consulta.edit', $item->id) }}" class="btn btn-edit me-2">
                                <span class="material-symbols-outlined align-middle">edit</span>
                                Editar
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
            @endforeach
        </tbody>

    </table>

</div>

@endsection
