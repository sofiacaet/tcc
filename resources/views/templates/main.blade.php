<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">

     <style>
            .nav-pills .nav-link.active {
                color: #FFF !important;
                background-color: rgb(7, 117, 190) !important;
            }
            .nav-pills .nav-link {
                color: rgb(7, 114, 190) !important;
            }

            .btn-tiffany {
            background-color: rgb(7, 117, 190) !important;
            color: #FFF !important;
            border: none !important;
            }
            .btn-tiffany:hover {
                background-color: #45cdef !important; /* um pouco mais escuro no hover */
                color: #FFF !important;
            }

    </style>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-md navbar-dark" style="background-color: rgb(7, 117, 190);">
        <div class="container-fluid">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('assets/img/logo.png') }}" style="border-radius: 25%;" width="56" height="56">
                <span class="ms-2 fs-4 fw-bold">Sistema Pré-Natal</span>
            </a>
           <button class="navbar-toggler d-inline-flex align-items-center justify-content-center" data-bs-toggle="collapse" data-bs-target="#itens" style="border: none;">
                <span class="material-symbols-outlined text-white" style="font-size: 30px;">menu</span>
            </button>
            <div class="collapse navbar-collapse" id="itens">
                <ul class="navbar-nav ms-auto">

                    @can('viewAny', App\Models\Gestante::class)
                        <li class="nav-item me-2">
                            <a href="{{ route('gestante.index') }}" class="nav-link d-inline-flex align-items-center text-white">
                                <span class="material-symbols-outlined" style="font-size: 40px;">pregnant_woman</span>
                                <span class="ps-1">Gestantes</span>
                            </a>
                        </li>
                    @endcan

                    @can('viewAny', App\Models\Consulta::class)
                        <li class="nav-item me-2">
                            <a href="{{ route('consulta.index') }}" class="nav-link d-inline-flex align-items-center text-white">
                                <span class="material-symbols-outlined" style="font-size: 40px;" >stethoscope</span>
                                <span class="ps-1">Consultas</span>
                            </a>
                        </li>
                    @endcan

                    @can('viewAny', App\Models\Exame::class)
                        <li class="nav-item me-2">
                            <a href="{{ route('exame.index') }}" class="nav-link d-inline-flex align-items-center text-white">
                                <span class="material-symbols-outlined" style="font-size: 40px;" >description</span>
                                <span class="ps-1">Exames</span>
                            </a>
                        </li>
                    @endcan

                    @can('viewAny', App\Models\Orientacao::class)
                        <li class="nav-item me-2">
                            <a href="{{ route('orientacao.index') }}" class="nav-link d-inline-flex align-items-center text-white">
                                <span class="material-symbols-outlined" style="font-size: 40px;">chat</span>
                                <span class="ps-1">Orientações</span>
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item dropdown pe-3">
                       <a class="nav-link dropdown-toggle d-inline-flex align-items-center text-white" data-bs-toggle="dropdown" href="#">
                            <span class="material-symbols-outlined text-white" style="font-size: 40px;">account_circle</span>
                            @auth
                                <span class="ps-1">{{ Auth::user() ? explode(" ", Auth::user()->name)[0] : 'Anônimo' }}</span>
                            @endauth
                        </a>
                        <ul class="dropdown-menu">
                             <li>
                                <a href="" class="dropdown-item d-inline-flex align-items-center text-secondary">
                                    <span class="material-symbols-outlined me-1" style="color: rgb(7, 111, 190);">key</span>
                                    <span>Alterar Senha</span>
                                </a>
                            </li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li>
                                    <a href="" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item d-inline-flex align-items-center text-secondary">
                                        <span class="material-symbols-outlined me-1" style="color: rgb(7, 114, 190);">logout</span>
                                        <span>Sair</span>
                                    </a>
                                </li>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <div class="row">
            <div class="col">
                @if($cabecalho != '')
                    <h3 class="text-secondary"><b>{{ $cabecalho }}</b></h3>
                @endif
            </div>
            <div class="col d-flex justify-content-end">
                @if($rota != '')
                    @can("create", $class)
                        <a href="{{ route($rota) }}" class="btn btn-tiffany ms-2 d-inline-flex align-items-center justify-content-center">
                            <span class="material-symbols-outlined text-white">add_circle</span>
                        </a>
                    @endcan
                @endif
                @if($relatorio != '')
                    <a href="{{ route($relatorio) }}" class="btn btn-tiffany ms-2 d-inline-flex align-items-center justify-content-center" target="_blank">
                        <span class="material-symbols-outlined text-white">print_connect</span>
                    </a>
                @endif
            </div>
        </div>
        <hr>
        @yield('conteudo')
    </div>
    <nav class="navbar fixed-bottom navbar-dark" style="background-color: rgb(7, 117, 190);">
        <div class="container-fluid">
            <span class="text-white">&copy; Todos os direitos reservados.</span>
        </div>
    </nav>
</body>

<div class="modal fade" tabindex="-1" id="removeModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Operação de Remoção</h5>
          <button type="button" class="btn-close" data-bs-dismiss="removeModal" onclick="closeRemoveModal()" aria-label="Close"></button>
        </div>
        <input type="hidden" id="id_remove">
        <div class="modal-body text-secondary">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-block d-inline-flex align-items-center gap-1" onclick="closeRemoveModal()">
                <span class="material-symbols-outlined">arrow_back</span>
                Não
            </button>
            <button type="button" class="btn btn-danger d-inline-flex align-items-center gap-1" onclick="remove()">
                Sim
                <span class="material-symbols-outlined">check_circle</span>
            </button>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">

    function showRemoveModal(id, nome) {
        $('#id_remove').val(id);
        $('#removeModal').modal().find('.modal-body').html("");
        $('#removeModal').modal().find('.modal-body').append("<b>'"+nome+"'</b> ?");
        $("#removeModal").modal('show');
    }

    function closeRemoveModal() {
        $("#removeModal").modal('hide');
    }

    function remove() {

        let id = $('#id_remove').val();
        let form = "form_" + $('#id_remove').val();
        document.getElementById(form).submit();
        $("#removeModal").modal('hide')
    }

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
@yield('script')
</html>
