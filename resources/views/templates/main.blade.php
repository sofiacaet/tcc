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
        /* Zerar margens globais para o cabeçalho colar no topo */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* NAV PILLS (Abas / Navegações) */
        .nav-pills .nav-link.active {
            color: #FFFFFF !important;
            background-color: #275553 !important;
        }
        .nav-pills .nav-link {
            color: #275553 !important;
        }

        /* BOTÃO PRINCIPAL (Antigo Tiffany, agora Verde-Petróleo) */
        .btn-tiffany {
            background-color: #275553 !important;
            color: #FFFFFF !important;
            border: none !important;
            transition: all 0.2s ease-in-out;
        }
        .btn-tiffany:hover {
            background-color: #1f4442 !important; /* Tom mais escuro no hover */
            color: #FFFFFF !important;
        }

        /* LINKS DE NAVEGAÇÃO / MENUS */
        .text-white-90 {
            color: rgba(255, 255, 255, 0.88) !important;
        }
        .text-white-90:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.12) !important;
        }
        .text-dark-green {
            color: #275553 !important;
        }
        .text-dark-green:hover {
            background-color: #f2f7f7 !important;
        }
        .transition {
            transition: all 0.2s ease-in-out;
        }


        /* Estilos do Dropdown de Notificações */
        .notification-dropdown {
            width: 350px;
            padding: 0;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin-top: 10px;
        }
        
        /* Triângulo apontando para cima */
        .notification-dropdown::before {
            content: "";
            position: absolute;
            top: -8px;
            right: 12px;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #fff;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            background: #fff;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .notification-title {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            margin: 0;
        }

        .notification-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-notif-action {
            background: none;
            border: none;
            padding: 2px 4px;
            display: inline-flex;
            align-items: center;
            color: #555;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-notif-action:hover {
            color: #000;
            background-color: #f8f9fa;
        }

        .notification-body {
            min-height: 250px;
            background: #fff;
            max-height: 350px;
            overflow-y: auto;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .notification-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
            color: #555;
            font-size: 14px;
        }

        /* Item de notificação caso tenha mensagens */
        .notif-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f5f5f5;
            text-decoration: none;
            color: #333;
            display: block;
            transition: 0.2s;
        }
        .notif-item:hover {
            background: #f8f9fa;
        }
        .notif-item.unread {
            background: #eaf3f3; /* Fundo para não lida */
        }
    </style>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-md shadow-md" style="background-color: #275553; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container-fluid px-4 py-1">
        
        <!-- Logo & Título -->
        <div class="navbar-brand d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 44px; height: 44px;">
                <span class="material-symbols-outlined" style="color: #275553; font-size: 26px;">child_care</span>
            </div>
            <span class="fs-4 fw-bold text-white tracking-wide">Gestapguá</span>
        </div>

        <!-- Botão Mobile / Toggler -->
        <button class="navbar-toggler border-0 shadow-none text-white p-2" type="button" data-bs-toggle="collapse" data-bs-target="#itens">
            <span class="material-symbols-outlined" style="font-size: 32px;">menu</span>
        </button>

        <!-- Itens da Navegação -->
        <div class="collapse navbar-collapse" id="itens">
            <ul class="navbar-nav mx-auto align-items-center gap-1 mt-3 mt-md-0">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link text-white-90 hover-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill transition">
                        <span class="material-symbols-outlined" style="font-size: 22px;">home</span>
                        <span class="fw-medium text-sm">Início</span>
                    </a>
                </li>

                @can('viewAny', App\Models\Gestante::class)
                    <li class="nav-item">
                        <a href="{{ route('gestante.index') }}" class="nav-link text-white-90 hover-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill transition">
                            <span class="material-symbols-outlined" style="font-size: 22px;">pregnant_woman</span>
                            <span class="fw-medium text-sm">Gestantes</span>
                        </a>
                    </li>
                @endcan

                @can('viewAny', App\Models\Consulta::class)
                    <li class="nav-item">
                        <a href="{{ route('consulta.index') }}" class="nav-link text-white-90 hover-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill transition">
                            <span class="material-symbols-outlined" style="font-size: 22px;">stethoscope</span>
                            <span class="fw-medium text-sm">Consultas</span>
                        </a>
                    </li>
                @endcan

                @can('viewAny', App\Models\Exame::class)
                    <li class="nav-item">
                        <a href="{{ route('exame.index') }}" class="nav-link text-white-90 hover-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill transition">
                            <span class="material-symbols-outlined" style="font-size: 22px;">description</span>
                            <span class="fw-medium text-sm">Exames</span>
                        </a>
                    </li>
                @endcan

                @can('viewAny', App\Models\Orientacao::class)
                    <li class="nav-item">
                        <a href="{{ route('orientacao.index') }}" class="nav-link text-white-90 hover-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill transition">
                            <span class="material-symbols-outlined" style="font-size: 22px;">chat</span>
                            <span class="fw-medium text-sm">Orientações</span>
                        </a>
                    </li>
                @endcan
            </ul>

            <ul class="navbar-nav align-items-center gap-1">

                <!-- NOTIFICAÇÕES (Transformado em li.nav-item para seguir a mesma identidade dos outros botões) -->
                <li class="nav-item dropdown">
                    <button class="nav-link text-white-90 hover-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill transition border-0 bg-transparent w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="bellDropdown">
                        <div class="position-relative d-inline-flex align-items-center">
                            <span class="material-symbols-outlined" style="font-size: 22px;">notifications</span>
                            
                            {{-- Bolinha com o número de notificações não lidas --}}
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 9px; margin-left: -5px; margin-top: 2px;">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </div>
                        
                    </button>

                    <!-- O PAINEL DE NOTIFICAÇÕES -->
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown shadow-lg mt-2" aria-labelledby="bellDropdown">
                        
                        <div class="notification-header">
                            <h6 class="notification-title">Notificações</h6>
                            <div class="notification-actions">
                                {{-- Botão Fechar --}}
                                <button class="btn-notif-action" title="Fechar" onclick="document.getElementById('bellDropdown').click()">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                                </button>
                            </div>
                        </div>

                        <div class="notification-body">
                            @if(auth()->user()->unreadNotifications->isEmpty())
                                {{-- MENSAGEM VAZIA --}}
                                <div class="notification-empty">
                                    Você não tem nenhuma notificação
                                </div>
                            @else
                                {{-- LISTA DE NOTIFICAÇÕES --}}
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="notif-item unread">
                                        <strong>{{ $notification->data['titulo'] }}</strong><br>
                                        <small class="text-muted">{{ $notification->data['mensagem'] }}</small>
                                    </a>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </li>

                <!-- Menu do Usuário -->
                <li class="nav-item dropdown ms-md-2 mt-2 mt-md-0">
                    <a class="nav-link dropdown-toggle bg-white text-dark-green fw-bold px-3 py-2 rounded-pill d-flex align-items-center gap-2 shadow-sm" 
                        data-bs-toggle="dropdown" 
                        href="#" 
                        role="button" 
                        aria-expanded="false"
                        style="color: #275553; background-color: #ffffff;">
                        <span class="material-symbols-outlined" style="font-size: 22px; color: #275553;">account_circle</span>
                        @auth
                            <span>{{ Auth::user() ? explode(" ", Auth::user()->name)[0] : 'Anônimo' }}</span>
                        @endauth
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-4 overflow-hidden p-2" style="min-width: 200px;">
                        <li>
                            <a href="" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-3 text-secondary">
                                <span class="material-symbols-outlined fs-5" style="color: #275553;">key</span>
                                <span class="fw-medium">Alterar Senha</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li>
                                <a href="" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 rounded-3 text-danger">
                                    <span class="material-symbols-outlined fs-5">logout</span>
                                    <span class="fw-medium">Sair</span>
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