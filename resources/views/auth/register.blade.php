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
            background: #f2f7f7;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .page-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .left-side {
            flex: 1.2;
            background: #275553;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            color: white;
            position: relative;
        }

        .left-content {
            max-width: 500px;
        }

        .left-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #275553;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .right-side {
            flex: 1;
            background: #f2f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            padding: 45px 40px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(39, 85, 83, 0.08);
            border: 1px solid #eaf3f3;
        }

        .title {
            text-align: left;
            font-size: 26px;
            font-weight: 700;
            color: #275553;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 24px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #275553;
            margin-bottom: 6px;
            display: block;
        }

        .input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #d3e5e5;
            background: #f9fbfb;
            margin-bottom: 16px;
            transition: all 0.2s ease;
            font-size: 14px;
            color: #334155;
            box-sizing: border-box;
        }

        .input:focus {
            outline: none;
            border-color: #275553;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(39, 85, 83, 0.15);
        }

        .login-link-wrapper {
            text-align: center;
            margin-top: 18px;
        }

        .login-link {
            color: #275553;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .btn-register {
            width: 100%;
            background: #275553;
            padding: 13px;
            border-radius: 50px;
            color: white;
            font-weight: 700;
            text-align: center;
            border: none;
            transition: all 0.2s ease;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(39, 85, 83, 0.2);
            margin-top: 8px;
        }

        .btn-register:hover {
            background: #1f4442;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(39, 85, 83, 0.28);
        }

        @media (max-width: 768px) {
            .page-wrapper {
                flex-direction: column;
            }
            .left-side {
                padding: 40px 20px;
            }
            .right-side {
                padding: 30px 16px;
            }
        }

        /* Animação do cursor piscando */
        .cursor {
            animation: blink 0.7s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    </style>

    <!-- Ícones Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <div class="page-wrapper">

        <!-- Lado Esquerdo -->
        <div class="left-side">
            <div class="left-content">
                <div class="left-header">
                    <!-- Ícone em destaque -->
                    <div class="logo-icon">
                        <i data-lucide="baby" style="width: 36px; height: 36px;"></i>
                    </div>
                    
                    <!-- Texto com Efeito de Digitação -->
                    <div style="display: flex; align-items: center;">
                        <span id="typing-text" style="font-size: 46px; font-weight: 800; color: #ffffff; min-height: 56px; display: inline-block;"></span>
                        <span class="cursor" style="font-size: 46px; font-weight: 300; color: #ffffff; margin-left: 2px;">|</span>
                    </div>
                </div>

                <!-- Descrição -->
                <h1 style="font-size: 20px; font-weight: 500; line-height: 1.5; color: #eaf3f3; opacity: 0.9; margin-top: 10px;">
                    Acompanhamento gestacional nas Ilhas do município de Paranaguá.
                </h1>
            </div>
        </div>

        <!-- Lado Direito (Formulário) -->
        <div class="right-side">
            <div class="register-card">

                <h2 class="title">Criar Conta</h2>
                <p class="subtitle">Preencha seus dados para se cadastrar</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nome Completo -->
                    <div>
                        <label for="name">Nome Completo</label>
                        <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" placeholder="Seu nome completo" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mb-2" />
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label for="email">E-mail</label>
                        <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mb-2" />
                    </div>

                    <!-- Senha -->
                    <div>
                        <label for="password">Senha</label>
                        <input id="password" class="input" type="password" name="password" placeholder="Sua senha" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mb-2" />
                    </div>

                    <!-- Confirmar Senha -->
                    <div>
                        <label for="password_confirmation">Confirmar Senha</label>
                        <input id="password_confirmation" class="input" type="password" name="password_confirmation" placeholder="Repita sua senha" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mb-2" />
                    </div>

                    <!-- Botão de Cadastrar -->
                    <button type="submit" class="btn-register">Registrar</button>

                    <!-- Link para Login -->
                    <div class="login-link-wrapper">
                        <a href="{{ route('login') }}" class="login-link">Já possui uma conta? Entrar</a>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();

        document.addEventListener("DOMContentLoaded", function () {
            const words = ["Gestapguá", "Pré-Natal Digital"];
            const typingElement = document.getElementById("typing-text");
            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;

            function typeEffect() {
                const currentWord = words[wordIndex];

                if (!isDeleting) {
                    typingElement.textContent = currentWord.substring(0, charIndex + 1);
                    charIndex++;

                    if (charIndex === currentWord.length) {
                        setTimeout(() => { isDeleting = true; typeEffect(); }, 2000);
                        return;
                    }
                } else {
                    typingElement.textContent = currentWord.substring(0, charIndex - 1);
                    charIndex--;

                    if (charIndex === 0) {
                        isDeleting = false;
                        wordIndex = (wordIndex + 1) % words.length;
                        setTimeout(typeEffect, 400);
                        return;
                    }
                }

                const speed = isDeleting ? 60 : 120;
                setTimeout(typeEffect, speed);
            }

            typeEffect();
        });
    </script>

</x-guest-layout>