<x-guest-layout>

    {{-- REMOVE AS RESTRIÇÕES DE LARGURA DO BREEZE --}}
    <style>
        main {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #e8fff6;
            font-family: 'Poppins', sans-serif;
        }

        .page-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .left-side {
            flex: 1.2;
            background: linear-gradient(160deg, #75c8ff, #193b68, #4dabf8);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .left-content h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .left-content p {
            font-size: 20px;
            opacity: 0.9;
        }

        .right-side {
            flex: 1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 45px 40px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            border: 2px solid #193b68;
        }

        .title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #193b68;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #193b68;
            margin-bottom: 6px;
            display: block;
        }

        .input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 2px solid #193b68;
            background: #f3fffb;
            margin-bottom: 15px;
            transition: 0.2s;
        }

        .input:focus {
            border-color: #193b68;
            box-shadow: 0 0 8px #193b68;
        }

        .btn-login {
            width: 100%;
            background: #193b68;
            padding: 12px;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            text-align: center;
            border: none;
            transition: 0.25s;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #193b68;
            transform: scale(1.02);
        }

        .forgot {
            display: block;
            text-align: right;
            color: #193b68;
            margin-top: -5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .forgot:hover {
            color: #193b68;
        }

        .check-area {
            margin-top: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .check-area span {
            color: #193b68;
            font-size: 14px;
        }
    </style>

    <div class="page-wrapper">

        <div class="left-side">
            <div class="left-content">
                <h1>GESTAPGUA</h1>
                <p>Sistema de Pré-Natal Digital para o acompanhamento gestacional nas Ilhas do município de Paranaguá</p>
            </div>
        </div>

        <div class="right-side">
            <div class="login-card">

                <h2 class="title">Acessar Conta</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input id="email" class="input" type="email" name="email" required autofocus>

                    <label for="password">Senha</label>
                    <input id="password" class="input" type="password" name="password" required>

                    <a href="{{ route('password.request') }}" class="forgot">Esqueceu sua senha?</a>

                    <div class="check-area">
                        <input type="checkbox" id="remember_me" name="remember">
                        <span>Lembrar de mim</span>
                    </div>

                    <button class="btn-login">Entrar</button>
                </form>

            </div>
        </div>

    </div>

</x-guest-layout>
