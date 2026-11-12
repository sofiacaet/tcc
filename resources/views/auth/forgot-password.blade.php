<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Gestapguá</title>
    
    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Ícones Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            /* Fundo ocupando a tela toda com a cor verde clara */
            background-color: #c5dede;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .page-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* A caixa do meio permanece exatamente igual */
        .recovery-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            padding: 48px 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(39, 85, 83, 0.08);
            border: 1px solid #eaf3f3;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: #275553;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(39, 85, 83, 0.25);
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: 800;
            color: #275553;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
            margin-top: 0;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #64748b;
            margin-bottom: 32px;
            line-height: 1.6;
            margin-top: 0;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #275553;
            margin-bottom: 8px;
            display: block;
        }

        .input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid #d3e5e5;
            background: #f9fbfb;
            margin-bottom: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            color: #334155;
        }

        .input:focus {
            outline: none;
            border-color: #275553;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(39, 85, 83, 0.15);
        }

        .btn-submit {
            width: 100%;
            background: #275553;
            padding: 14px;
            border-radius: 50px;
            color: white;
            font-weight: 700;
            text-align: center;
            border: none;
            transition: all 0.2s ease;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(39, 85, 83, 0.2);
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: #1f4442;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(39, 85, 83, 0.28);
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 24px;
            color: #275553;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .back-link:hover {
            color: #1f4442;
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
            margin-bottom: 12px;
            display: block;
            font-weight: 500;
        }

        .success-alert {
            background-color: #ecfdf5;
            color: #065f46;
            padding: 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            border: 1px solid #a7f3d0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        @media (max-width: 480px) {
            .recovery-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>

    <div class="page-wrapper">
        <div class="recovery-card">
            
            <div class="logo-container">
                <div class="logo-icon">
                    <i data-lucide="baby" style="width: 36px; height: 36px;"></i>
                </div>
            </div>

            <h2 class="title">Recuperar Senha</h2>
            <p class="subtitle">Informe o e-mail cadastrado na plataforma e enviaremos instruções para criar uma nova senha.</p>

            <!-- Mensagem de Sucesso de Envio -->
            @if (session('status'))
                <div class="success-alert">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Formulário -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label for="email">E-mail Cadastrado</label>
                    <input id="email" class="input" type="email" name="email" placeholder="seu@email.com" value="{{ old('email') }}" required autofocus>
                    
                    <!-- Mensagem de Erro -->
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Enviar Link de Recuperação
                </button>
                
                <a href="{{ route('login') }}" class="back-link">
                    Voltar para o Login
                </a>
            </form>

        </div>
    </div>

    <script>
        // Inicializa os ícones
        lucide.createIcons();
    </script>

</body>
</html>