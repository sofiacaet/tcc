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
            background: linear-gradient(160deg, #00c9a7, #009e87, #00bfa5);
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
            border: 2px solid #00c9a76b;
        }

        .title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #008f7a;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #009e87;
            margin-bottom: 6px;
            display: block;
        }

        .input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 2px solid #00c2a2;
            background: #f3fffb;
            margin-bottom: 15px;
            transition: 0.2s;
        }

        .input:focus {
            border-color: #007f6e;
            box-shadow: 0 0 8px #00bfa5;
            outline: none;
        }

        .btn-login {
            width: 100%;
            background: #00a88f;
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
            background: #007f6e;
            transform: scale(1.02);
        }

        .muted-link {
            display: block;
            text-align: right;
            color: #008f7a;
            margin-top: -5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .muted-link:hover {
            color: #005f51;
        }
    </style>

    <div class="page-wrapper">

        <div class="left-side">
            <div class="left-content">
                <h1>NUTRITIONIST</h1>
                <p>Sistema profissional para gestão de gestantes, dietas e acompanhamentos.</p>
            </div>
        </div>

        <div class="right-side">
            <div class="login-card">

                <h2 class="title">Criar Conta</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nome -->
                    <label for="name">Nome Completo</label>
                    <input id="name" class="input" type="text" name="name" :value="old('name')" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <!-- Email -->
                    <label for="email">Email</label>
                    <input id="email" class="input" type="email" name="email" :value="old('email')" value="{{ old('email') }}" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <!-- Senha -->
                    <label for="password">Senha</label>
                    <input id="password" class="input" type="password" name="password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <!-- Confirmar Senha -->
                    <label for="password_confirmation">Confirmar Senha</label>
                    <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <a href="{{ route('login') }}" class="muted-link">Já possui conta? Entrar</a>

                    <button type="submit" class="btn-login">Registrar</button>
                </form>

            </div>
        </div>

    </div>

</x-guest-layout>
