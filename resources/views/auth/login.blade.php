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
            gap: 12px;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #275553;
        }

        .left-content h1 {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .left-content p {
            font-size: 16px;
            color: #eaf3f3;
            line-height: 1.6;
            opacity: 0.9;
        }

        .badge-island {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #eaf3f3;
            margin-bottom: 20px;
        }

        .right-side {
            flex: 1;
            background: #f2f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
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
            margin-bottom: 28px;
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
            margin-bottom: 18px;
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

        .forgot-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .forgot {
            color: #275553;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .check-area {
            margin-top: 4px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .check-area input[type="checkbox"] {
            accent-color: #275553;
            width: 16px;
            height: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .check-area span {
            color: #475569;
            font-size: 13px;
        }

        .btn-login {
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
        }

        .btn-login:hover {
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
                <div class="left-header" style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
                <!-- Ícone grande em destaque -->
                <div class="logo-icon" style="width: 64px; height: 64px; background: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #275553; box-shadow: 0 8px 20px rgba(0,0,0,0.15); flex-shrink: 0;">
                    <i data-lucide="baby" style="width: 36px; height: 36px;"></i>
                </div>
                
                <!-- Texto Grande com Efeito de Digitação/Reescrita -->
                <div style="display: flex; align-items: center;">
                    <span id="typing-text" style="font-size: 46px; font-weight: 800; tracking-tight: -1px; color: #ffffff; min-height: 56px; display: inline-block;"></span>
                    <span class="cursor" style="font-size: 46px; font-weight: 300; color: #ffffff; margin-left: 2px;">|</span>
                </div>
            </div>
              

                <!-- Texto fixo menor e direto -->
<h1 style="font-size: 20px; font-weight: 500; line-height: 1.5; color: #eaf3f3; opacity: 0.9; margin-top: 10px;">
    Acompanhamento gestacional nas Ilhas do município de Paranaguá.
</h1>
                
            </div>
        </div>

        <!-- Lado Direito -->
        <div class="right-side">
            <div class="login-card">

                <h2 class="title">Acessar Conta</h2>
                <p class="subtitle">Informe seus dados para acessar a plataforma</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email">E-mail</label>
                        <input id="email" class="input" type="email" name="email" placeholder="seu@email.com" required autofocus>
                    </div>

                    <div>
                        <div class="forgot-wrapper">
                            <label for="password" style="margin-bottom: 0;">Senha</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot">Esqueceu sua senha?</a>
                            @endif
                        </div>
                        <input id="password" class="input" type="password" name="password" placeholder="Senha" required>
                    </div>

                    <div class="check-area">
                        <input type="checkbox" id="remember_me" name="remember">
                        <span>Lembrar de mim</span>
                    </div>

                    <button type="submit" class="btn-login">Entrar</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();

        document.addEventListener("DOMContentLoaded", function () {
            // Lista com os dois textos para alternar
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
                        // Alterna para a próxima palavra da lista
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