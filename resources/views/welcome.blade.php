<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>WebBoi - Sistema de Gestão Pecuária de Corte</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            /* Padrão moderno e elegante */
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: 
                    radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
                opacity: 1;
                pointer-events: none;
            }

            .background-pattern {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0.1;
                background-image: 
                    radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
                pointer-events: none;
            }

            .hero-container {
                position: relative;
                z-index: 2;
                min-height: 100vh;
                display: flex;
                align-items: center;
                padding: 2rem 0;
            }

            .auth-buttons {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
            }

            .auth-buttons .btn {
                margin-left: 10px;
                border-radius: 25px;
                padding: 8px 20px;
                font-weight: 500;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .btn-outline-light:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                border-color: rgba(255, 255, 255, 0.5);
            }

            .btn-light {
                background: rgba(255, 255, 255, 0.9);
                color: #667eea;
                font-weight: 600;
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .btn-light:hover {
                background: white;
                color: #5a67d8;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            }

            .hero-content {
                text-align: center;
                color: white;
                max-width: 800px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .logo-container {
                margin-bottom: 2rem;
            }

            .logo {
                font-size: 4rem;
                font-weight: 700;
                background: linear-gradient(45deg, #fff, #f0f0f0);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 0.5rem;
            }

            .tagline {
                font-size: 1.4rem;
                font-weight: 300;
                opacity: 0.9;
                margin-bottom: 3rem;
            }

            /* Ícones decorativos modernos */
            .field-decoration {
                position: absolute;
                font-size: 1.2rem;
                opacity: 0.08;
                animation: float 8s ease-in-out infinite;
                color: rgba(255, 255, 255, 0.6);
            }

            .field-decoration:nth-child(1) {
                top: 15%;
                left: 10%;
                animation-delay: -1s;
            }

            .field-decoration:nth-child(2) {
                top: 25%;
                right: 15%;
                animation-delay: -3s;
            }

            .field-decoration:nth-child(3) {
                bottom: 30%;
                left: 20%;
                animation-delay: -5s;
            }

            .field-decoration:nth-child(4) {
                bottom: 15%;
                right: 10%;
                animation-delay: -2s;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(5deg); }
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                grid-template-rows: repeat(2, 1fr);
                gap: 2rem;
                margin: 3rem 0;
                max-width: 1200px;
                margin-left: auto;
                margin-right: auto;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 16px;
                padding: 2rem;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-5px);
                background: rgba(255, 255, 255, 0.15);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .feature-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
                color: #fff;
            }

            .feature-title {
                font-size: 1.3rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: #fff;
            }

            .feature-description {
                font-size: 1rem;
                opacity: 0.9;
                line-height: 1.6;
                color: #fff;
            }

            .cta-section {
                margin-top: 4rem;
            }

            .cta-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .cta-btn {
                padding: 15px 40px;
                border-radius: 30px;
                font-weight: 600;
                font-size: 1.1rem;
                text-decoration: none;
                transition: all 0.3s ease;
                border: 2px solid transparent;
                display: inline-flex;
                align-items: center;
                gap: 10px;
            }

            .cta-btn-primary {
                background: linear-gradient(45deg, #fff, #f0f0f0);
                color: #667eea;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                font-weight: 600;
            }

            .cta-btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
                color: #5a67d8;
                background: linear-gradient(45deg, #ffffff, #f8f9fa);
            }

            .cta-btn-secondary {
                background: transparent;
                color: white;
                border: 2px solid rgba(255, 255, 255, 0.3);
            }

            .cta-btn-secondary:hover {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(255, 255, 255, 0.5);
                transform: translateY(-3px);
                color: white;
            }

            .system-stats {
                margin-top: 4rem;
                display: flex;
                justify-content: center;
                gap: 3rem;
                flex-wrap: wrap;
            }

            .stat-item {
                text-align: center;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #fff;
                display: block;
            }

            .stat-label {
                font-size: 1rem;
                opacity: 0.8;
                color: #fff;
            }

            .contact-info {
                margin: 2rem 0;
            }

            .contact-item {
                margin-bottom: 2rem;
                padding: 0 1rem;
            }

            /* Espaçamento adicional para desktop */
            @media (min-width: 768px) {
                .contact-row {
                    gap: 2rem;
                }
                
                .contact-col {
                    padding: 0 2rem;
                }
            }

            .contact-link {
                color: white;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                padding: 12px 20px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 25px;
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(10px);
                font-size: 1rem;
                font-weight: 500;
            }

            .contact-link:hover {
                color: white;
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                text-decoration: none;
            }

            .contact-link i {
                font-size: 1.2rem;
            }

            .fa-whatsapp {
                color: #25D366;
            }

            .fa-envelope {
                color: #EA4335;
            }

            @media (max-width: 1024px) and (min-width: 769px) {
                .features-grid {
                    grid-template-columns: repeat(2, 1fr);
                    grid-template-rows: repeat(3, 1fr);
                    gap: 1.8rem;
                }
            }

            @media (max-width: 768px) {
                .logo {
                    font-size: 3rem;
                }

                .tagline {
                    font-size: 1.2rem;
                }

                .features-grid {
                    grid-template-columns: 1fr;
                    grid-template-rows: auto;
                    gap: 1.5rem;
                }

                .cta-buttons {
                    flex-direction: column;
                    align-items: center;
                }

                .system-stats {
                    gap: 2rem;
                }

                .auth-buttons {
                    position: static;
                    text-align: center;
                    margin-bottom: 2rem;
                }

                .hero-container {
                    padding-top: 1rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="background-pattern"></div>
        
        <!-- Elementos decorativos modernos -->
        <div class="field-decoration"><i class="fas fa-chart-line"></i></div>
        <div class="field-decoration"><i class="fas fa-database"></i></div>
        <div class="field-decoration"><i class="fas fa-cog"></i></div>
        <div class="field-decoration"><i class="fas fa-analytics"></i></div>
        
        <!-- Auth Buttons -->
        @if (Route::has('login'))
            <div class="auth-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-light">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-light">
                            <i class="fas fa-user-plus me-2"></i>Registrar
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="hero-container">
            <div class="container">
                <div class="hero-content">
                    <div class="logo-container">
                        <div class="logo">
                            <i class="fas fa-cow me-3"></i>WebBoi
                        </div>
                        <div class="tagline">
                            Sistema de Gestão Pecuária de Corte
                        </div>
                    </div>

                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="feature-title">Controle Financeiro</div>
                            <div class="feature-description">
                                Gerencie compras, vendas, despesas operacionais e acompanhe a rentabilidade do seu rebanho de corte em tempo real.
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="feature-title">Saúde Animal</div>
                            <div class="feature-description">
                                Controle de medicamentos, alimentação, peso dos animais e mantenha histórico completo de saúde do gado de corte.
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="feature-title">Gestão de Pessoas</div>
                            <div class="feature-description">
                                Cadastre vendedores, compradores, motoristas e mantenha contatos organizados para facilitar negociações.
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="feature-title">Logística</div>
                            <div class="feature-description">
                                Controle de fretes, agendamentos, locais de origem e destino para otimizar o transporte do gado de corte.
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="feature-title">Categorização</div>
                            <div class="feature-description">
                                Organize seu rebanho de corte por categorias, facilite a busca e mantenha controle detalhado de cada animal.
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="feature-title">Acesso Mobile</div>
                            <div class="feature-description">
                                Interface responsiva que funciona perfeitamente em computadores, tablets e smartphones.
                            </div>
                        </div>
                    </div>

                    <div class="cta-section">
                        <div class="cta-buttons">
                            @guest
                                <a href="{{ route('register') }}" class="cta-btn cta-btn-primary">
                                    <i class="fas fa-rocket"></i>
                                    Começar Agora
                                </a>
                                <a href="{{ route('login') }}" class="cta-btn cta-btn-secondary">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Já tenho conta
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="cta-btn cta-btn-primary">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Acessar Sistema
                                </a>
                            @endguest
                        </div>
                    </div>

                    <div class="system-stats">
                        <div class="stat-item">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Gratuito</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Disponível</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">∞</span>
                            <span class="stat-label">Animais</span>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="mt-5 pt-4" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <!-- Contato -->
                        <div class="contact-info mb-4">
                            <div class="row justify-content-center contact-row">
                                <div class="col-md-5 mb-3 contact-col">
                                    <div class="contact-item text-center mb-3">
                                        <a href="https://wa.me/5564999671030" target="_blank" class="contact-link">
                                            <i class="fab fa-whatsapp me-2"></i>
                                            <span>WhatsApp: (64) 9.9967-1030</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-3 contact-col">
                                    <div class="contact-item text-center mb-3">
                                        <a href="mailto:lourivalvsj@gmail.com" class="contact-link">
                                            <i class="fas fa-envelope me-2"></i>
                                            <span>E-mail: lourivalvsj@gmail.com</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-center text-white" style="opacity: 0.8; font-size: 0.9rem;">
                            Copyright © 2025 WebBoi - Sistema de Gestão Pecuária. Todos os direitos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
