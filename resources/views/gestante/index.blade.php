@extends('templates/main',
[
    'titulo'=>"Sistema Pre-Natal",
    'cabecalho' => 'Lista de Gestantes',
    'rota' => 'gestante.create',
    'relatorio' => 'report.gestante',
    'class' => App\Models\Gestante::class,
])
@section('conteudo')

<style>
:root{
    --green: #21867d;
    --green-strong: #70a1de;
    --green-light: #44df91;
    --danger: #f52424;
}

/* FUNDO */
body {
    background: linear-gradient(135deg, #75c8ff 0%, #4dabf8 50%, #193b68 100%);
    min-height: 100vh;
    padding: 22px;
    overflow: hidden;
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
     overflow-x: auto;
}

/* TABELA */
table.modern-table {
    width: 100%;
    max-width: 100%; /* GARANTE QUE NÃO ULTRAPASSE O CARD */
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
                <th>NOME</th>
                <th class="d-none d-md-table-cell">CONSULTA</th>
                <th class="d-none d-md-table-cell">EMAIL</th>
                <th class="d-none d-md-table-cell">TELEFONE</th>
                <th class="d-none d-md-table-cell">CPF</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gestantes as $item)
                <tr>
                    <td>{{ $item->nome }}</td>
                    <td class="d-none d-md-table-cell">{{ $item->consulta->nome }}</td>
                    <td class="d-none d-md-table-cell">{{ $item->email }}</td>
                    <td class="d-none d-md-table-cell">{{ $item->telefone }}</td>
                    <td class="d-none d-md-table-cell">{{ $item->cpf }}</td>
                   

                    <td class="text-nowrap">
                        <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="btn btn-outline-dark me-2">
                            <span class="material-symbols-outlined align-middle">photo_camera</span>
                        </a>
                        
                        @can('update', $item)
                            <a href="{{ route('gestante.edit', $item->id) }}" class="btn btn-edit me-2">
                                <span class="material-symbols-outlined align-middle">edit</span>
                                Editar
                            </a>
                        @endcan
                        
                        @can('delete', $item)
                            <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item->id }}', '{{ $item->nome }} - {{ $item->consulta->nome }}')" class="btn btn-delete"> 
                                <span class="material-symbols-outlined align-middle">delete</span> 
                                    Excluir
                            </a>
                            <form action="{{route('gestante.destroy', $item->id)}}" method="POST" id="form_{{$item->id}}">
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
