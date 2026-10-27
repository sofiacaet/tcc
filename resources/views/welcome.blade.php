<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PréNatal Digital - Ilhas de Paranaguá</title>

    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#254d4b] text-[#f2f7f7] antialiased"> 

    <!-- Cabeçalho Único -->
    <nav class="bg-[#275553] sticky top-0 z-50 border-b border-white/10 shadow-md" style="height: 80px;">
        <div class="max-w-7xl mx-auto px-6 h-full flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#275553] shadow-sm"  style="width: 44px; height: 44px;">
                    <i data-lucide="baby" style="width: 24px; height: 24px; color: #275553;"></i>
                   
                </div>
                <div>
                    <span class="text-2xl font-bold text-white block leading-none">Gestapguá</span>
                   
                </div>
            </div>

            <!-- Navegação & Autenticação -->
            <div class="flex items-center gap-6">
                <a href="#sobre" class="text-sm font-medium text-white/90 hover:text-white transition">
                    Sobre o projeto
                </a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-white hover:bg-teal-50 text-[#275553] px-5 py-2 rounded-full font-bold text-sm transition shadow-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-white/90 hover:text-white transition">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white hover:bg-teal-50 text-[#275553] px-5 py-2 rounded-full font-bold text-sm transition shadow-sm">
                                Cadastrar
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-12 md:py-20 bg-gradient-to-b from-[#eaf3f3] to-[#f2f7f7]">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                
                <h1 class="text-4xl md:text-5xl font-bold text-[#2d5c5c] leading-tight">
                    Cuidado completo para uma gestação tranquila e saudável
                </h1>
                <p class="text-gray-600 text-lg">
                    Acompanhe sua gestação de forma digital, segura e personalizada. Tudo que você precisa em um só lugar.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-[#3d7a7a] hover:bg-[#326464] text-white px-8 py-3.5 rounded-full font-medium transition shadow-md flex items-center gap-2">
                            <span>Acessar o serviço digital</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </div>
            
           <div class="flex justify-center items-center py-4">
                <!-- Imagem centralizada, sem moldura externa, sem cortar a foto e com proporção harmoniosa -->
                <img src="{{ asset('assets/img/gravida.png') }}" 
                    alt="Casal aguardando o bebê" 
                    class="w-full max-w-lg h-[400px] md:h-[450px] object-cover object-center rounded-2xl shadow-lg">
            </div>
        </div>
    </section>

    <!-- Grid de Recursos (Fiel à Imagem 1) -->
    <section class="bg-[#eaf3f3] py-8 border-y border-[#d3e5e5]">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-6 divide-x divide-[#c5dede]">
            
            <div class="flex flex-col items-center text-center px-2 py-4">
                <div class="w-16 h-16 rounded-full border border-[#3d7a7a] flex items-center justify-center text-[#3d7a7a] mb-4 bg-transparent">
                    <i data-lucide="calendar" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xs font-bold text-[#2d5c5c] leading-tight max-w-[130px]">Acompanhamento Personalizado</h3>
            </div>

            <div class="flex flex-col items-center text-center px-2 py-4">
                <div class="w-16 h-16 rounded-full border border-[#3d7a7a] flex items-center justify-center text-[#3d7a7a] mb-4 bg-transparent">
                    <i data-lucide="clipboard-check" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xs font-bold text-[#2d5c5c] leading-tight max-w-[130px]">Agendamento de Consultas</h3>
            </div>

            <div class="flex flex-col items-center text-center px-2 py-4">
                <div class="w-16 h-16 rounded-full border border-[#3d7a7a] flex items-center justify-center text-[#3d7a7a] mb-4 bg-transparent">
                    <i data-lucide="test-tube-2" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xs font-bold text-[#2d5c5c] leading-tight max-w-[130px]">Exames e Resultados</h3>
            </div>

            <div class="flex flex-col items-center text-center px-2 py-4">
                <div class="w-16 h-16 rounded-full border border-[#3d7a7a] flex items-center justify-center text-[#3d7a7a] mb-4 bg-transparent">
                    <i data-lucide="book-open" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xs font-bold text-[#2d5c5c] leading-tight max-w-[130px]">Conteúdos Confiáveis</h3>
            </div>

            <div class="flex flex-col items-center text-center px-2 py-4">
                <div class="w-16 h-16 rounded-full border border-[#3d7a7a] flex items-center justify-center text-[#3d7a7a] mb-4 bg-transparent">
                    <i data-lucide="messages-square" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xs font-bold text-[#2d5c5c] leading-tight max-w-[130px]">Tire Dúvidas com Profissionais</h3>
            </div>

            <div class="flex flex-col items-center text-center px-2 py-4">
                <div class="w-16 h-16 rounded-full border border-[#3d7a7a] flex items-center justify-center text-[#3d7a7a] mb-4 bg-transparent">
                    <i data-lucide="shield-check" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xs font-bold text-[#2d5c5c] leading-tight max-w-[130px]">Segurança e Privacidade</h3>
            </div>

        </div>
    </section>

    <!-- Seção de Tecnologia (Mockup Fiel à Imagem 2) -->
    <section id="sobre" class="py-16 bg-[#f9fbfb]">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            
            <!-- Mockup do Celular Fiel -->
            <div class="flex justify-center">
                <div class="w-[290px] h-[580px] bg-white rounded-[45px] shadow-2xl border-[9px] border-gray-900 p-4 flex flex-col justify-between relative overflow-hidden font-sans">
                    
                    <!-- Topo do Celular (Notch / Barra de Status) -->
                    <div>
                        <div class="flex justify-between items-center text-[10px] text-gray-700 font-bold px-3 pt-1">
                            <span>9:41</span>
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="signal" class="w-3 h-3"></i>
                                <i data-lucide="wifi" class="w-3 h-3"></i>
                                <i data-lucide="battery" class="w-3.5 h-3.5"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Conteúdo Interno da Tela do App -->
                    <div class="flex-1 mt-3 flex flex-col gap-3">
                        <h3 class="text-xl font-bold text-[#2d5c5c] px-1">Olá, mamãe!</h3>

                        <!-- Card Semana da Gestação -->
                        <div class="bg-[#eaf3f3] p-4 rounded-2xl flex items-center justify-between">
                            <div>
                                <p class="text-[11px] text-gray-500">Você está na</p>
                                <p class="text-xl font-bold text-[#2d5c5c]">Semana 24</p>
                                <p class="text-[11px] text-gray-500 font-medium">2º trimestre</p>
                            </div>
                            <!-- Círculo Ilustrativo do Feto -->
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#bfe0e0] to-[#88c4c4] p-1 flex items-center justify-center shadow-inner">
                                <div class="w-12 h-12 bg-white/40 rounded-full flex items-center justify-center">
                                    <i data-lucide="baby" class="w-7 h-7 text-[#2d5c5c]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Card Próxima Consulta -->
                        <div class="bg-[#f7fafae6] border border-gray-100 p-3.5 rounded-2xl space-y-2 shadow-sm">
                            <p class="text-[11px] text-gray-500 font-semibold">Próxima consulta</p>
                            <div>
                                <p class="text-sm font-bold text-[#2d5c5c]">20 de Maio</p>
                                <p class="text-[10px] text-gray-400">Terça-feira · 10:00</p>
                            </div>
                            <button class="w-full py-1.5 border border-[#3d7a7a] text-[#3d7a7a] text-xs font-semibold rounded-full bg-white hover:bg-[#eaf3f3] transition">
                                Ver detalhes
                            </button>
                        </div>

                        <!-- Card Seu Progresso -->
                        <div class="bg-[#f7fafae6] border border-gray-100 p-3.5 rounded-2xl space-y-2 shadow-sm">
                            <p class="text-[11px] text-gray-500 font-semibold">Seu progresso</p>
                            <div>
                                <p class="text-sm font-bold text-[#2d5c5c]">75%</p>
                                <p class="text-[10px] text-gray-400">do acompanhamento</p>
                            </div>
                            <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                                <div class="bg-[#5ea8a8] h-full w-[75%] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Nav Interno do App -->
                    <div class="border-t border-gray-100 pt-2 flex justify-around items-center text-center">
                        <div class="flex flex-col items-center text-[#3d7a7a]">
                            <i data-lucide="home" class="w-4 h-4"></i>
                            <span class="text-[9px] font-semibold mt-0.5">Início</span>
                        </div>
                        <div class="flex flex-col items-center text-gray-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span class="text-[9px] mt-0.5">Consultas</span>
                        </div>
                        <div class="flex flex-col items-center text-gray-400">
                            <i data-lucide="heart" class="w-4 h-4"></i>
                            <span class="text-[9px] mt-0.5">Conteúdos</span>
                        </div>
                        <div class="flex flex-col items-center text-gray-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span class="text-[9px] mt-0.5">Perfil</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Texto de Tecnologia -->
            <div class="space-y-6">
                <h2 class="text-3xl font-bold text-[#2d5c5c]">Tecnologia que cuida de você e do seu bebê</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Nosso objetivo é tornar o pré-natal mais acessível, organizado e acolhedor para as gestantes moradoras das ilhas do município de Paranaguá e seus profissionais de saúde.
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-[#eaf3f3] text-[#3d7a7a] rounded-xl mt-1">
                            <i data-lucide="smartphone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#2d5c5c] text-sm">Informações na palma da mão</h4>
                            <p class="text-xs text-gray-500">Acesse seus dados, consultas, exames e orientações sempre que precisar.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-[#eaf3f3] text-[#3d7a7a] rounded-xl mt-1">
                            <i data-lucide="heart-pulse" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#2d5c5c] text-sm">Acompanhamento completo</h4>
                            <p class="text-xs text-gray-500">Tenha uma visão clara de cada etapa da sua gestação e do desenvolvimento do bebê.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-[#eaf3f3] text-[#3d7a7a] rounded-xl mt-1">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#2d5c5c] text-sm">Conexão com profissionais</h4>
                            <p class="text-xs text-gray-500">Comunique-se com sua equipe de saúde de forma rápida, segura e prática.</p>
                        </div>
                    </div>
                </div>

                <a href="#sobre" class="inline-block bg-[#3d7a7a] hover:bg-[#326464] text-white px-6 py-2.5 rounded-full font-medium text-sm transition shadow-sm">
                    Conheça todos os recursos
                </a>
            </div>
        </div>
    </section>

    <!-- Como funciona? -->
    <section class="py-16 bg-[#eaf3f3] border-t border-[#d3e5e5] text-center">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-[#2d5c5c] mb-12">Como funciona?</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border border-[#3d7a7a]/30 text-[#3d7a7a] rounded-full flex items-center justify-center mb-4 relative shadow-sm">
                        <i data-lucide="user-plus" class="w-8 h-8"></i>
                        <span class="absolute -bottom-2 bg-[#3d7a7a] text-white text-xs w-6 h-6 rounded-full flex items-center justify-center font-bold">1</span>
                    </div>
                    <h3 class="font-bold text-[#2d5c5c] text-sm mb-1">Cadastre-se</h3>
                    <p class="text-xs text-gray-600 max-w-[200px]">Crie sua conta de forma simples e rápida.</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border border-[#3d7a7a]/30 text-[#3d7a7a] rounded-full flex items-center justify-center mb-4 relative shadow-sm">
                        <i data-lucide="calendar-check" class="w-8 h-8"></i>
                        <span class="absolute -bottom-2 bg-[#3d7a7a] text-white text-xs w-6 h-6 rounded-full flex items-center justify-center font-bold">2</span>
                    </div>
                    <h3 class="font-bold text-[#2d5c5c] text-sm mb-1">Acompanhe</h3>
                    <p class="text-xs text-gray-600 max-w-[200px]">Agende consultas, registre sintomas e acompanhe sua gestação.</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border border-[#3d7a7a]/30 text-[#3d7a7a] rounded-full flex items-center justify-center mb-4 relative shadow-sm">
                        <i data-lucide="file-text" class="w-8 h-8"></i>
                        <span class="absolute -bottom-2 bg-[#3d7a7a] text-white text-xs w-6 h-6 rounded-full flex items-center justify-center font-bold">3</span>
                    </div>
                    <h3 class="font-bold text-[#2d5c5c] text-sm mb-1">Acesse conteúdos</h3>
                    <p class="text-xs text-gray-600 max-w-[200px]">Receba informações confiáveis e personalizadas para cada fase.</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border border-[#3d7a7a]/30 text-[#3d7a7a] rounded-full flex items-center justify-center mb-4 relative shadow-sm">
                        <i data-lucide="heart" class="w-8 h-8"></i>
                        <span class="absolute -bottom-2 bg-[#3d7a7a] text-white text-xs w-6 h-6 rounded-full flex items-center justify-center font-bold">4</span>
                    </div>
                    <h3 class="font-bold text-[#2d5c5c] text-sm mb-1">Tenha mais tranquilidade</h3>
                    <p class="text-xs text-gray-600 max-w-[200px]">Sinta-se amparada em cada etapa dessa jornada única.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Rodapé (Verde-Petróleo Escuro #254d4b Fiel à Imagem Enviada) -->
    <footer class="bg-[#254d4b] text-white text-xs py-10">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-4">
           
            <p class="text-gray-200/90 text-xs">Programa de apoio ao pré-natal para as comunidades insulares do Município de Paranaguá - PR.</p>
            
           
        </div>
    </footer>

    <!-- Inicializar Ícones do Lucide -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>