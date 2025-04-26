<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - WebBoi</title>

    <link rel="sortcut icon" href="{{ asset('storage/img/favicon.png') }}" type="image/x-icon" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .nav-link:hover,
        .dropdown-item:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s;
            border-radius: 5px;
        }

        .dropdown-menu {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            transform: translateY(10px);
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/js.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-white">
    <header class="header header-with-topbar">
        <div class="container-fluid" style="background-color: #363537">
            <div class="row" style="height: 30px">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-12 d-flex justify-content-end">
                            {{-- <img src="{{ asset('storage/img/facebook-icon.png') }}" height="25px" alt="Facebook">
                            &nbsp;&nbsp;<img src="{{ asset('storage/img/instagram-icon.png') }}" height="25px"
                                alt="Instagram">
                            &nbsp;&nbsp;<img src="{{ asset('storage/img/email-icon.png') }}" height="25px"
                                alt="E-Mail"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @auth
        <div class="container-fluid shadow-sm bg-white sticky-top">
            <div class="container bg-white">
                <div class="row d-flex align-items-center">
                    <div class="col-2">
                        <a href="{{ route('dashboard') }}"><img class="py-1"
                                src="{{ asset('storage/img/WebBoiSemFundo.png') }}" width="180px"></a>
                    </div>
                    <div class="col-10 d-flex justify-content-end">
                        <nav class="nav navbar-expand-md navbar-light bg-white">
                            <div class="container">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarMenu">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarMenu">
                                    <ul class="nav flex-wrap">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                                href="{{ route('dashboard') }}">
                                                <i class="fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard
                                            </a>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->is('animals*') || request()->is('animal-weights*') || request()->is('feedings*') || request()->is('medications*') ? 'active' : '' }}"
                                                href="#" id="menuAnimal" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-cow"></i>&nbsp;&nbsp;Animais
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="menuAnimal">
                                                <li><a class="dropdown-item" href="{{ route('animals.index') }}">Gerenciar
                                                        Animais</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('animal-weights.index') }}">Pesagens</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('feedings.index') }}">Alimentações</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('medications.index') }}">Medicações</a></li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->is('purchases*') || request()->is('sales*') ? 'active' : '' }}"
                                                href="#" id="menuTransacoes" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Transações
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="menuTransacoes">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('purchases.index') }}">Compras</a></li>
                                                <li><a class="dropdown-item" href="{{ route('sales.index') }}">Vendas</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->is('vendors*') || request()->is('buyers*') || request()->is('categories*') || request()->is('locals*') ? 'active' : '' }}"
                                                href="#" id="menuCadastros" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-users"></i>&nbsp;&nbsp;Cadastros
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="menuCadastros">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('vendors.index') }}">Vendedores</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('buyers.index') }}">Compradores</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('categories.index') }}">Categorias</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('locals.index') }}">Locais</a></li>
                                                <!-- Link para Locais -->
                                                <li><a class="dropdown-item" href="{{ route('ufs.index') }}">UFs</a></li>
                                                <!-- Cadastrar UF -->
                                                <li><a class="dropdown-item"
                                                        href="{{ route('cities.index') }}">Cidades</a></li>
                                                <!-- Cadastrar Cidade -->
                                            </ul>
                                        </li>

                                        <!-- Novo submenu Despesas -->
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->is('supply-expenses*') || request()->is('operational-expenses*') ? 'active' : '' }}"
                                                href="#" id="menuDespesas" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;Despesas
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="menuDespesas">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('supply-expenses.index') }}">Gastos com Insumos</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('operational-expenses.index') }}">Despesas
                                                        Operacionais</a></li>
                                            </ul>
                                        </li>

                                        <!-- Novo submenu Transporte -->
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle {{ request()->is('truck-drivers*') || request()->is('freights*') ? 'active' : '' }}"
                                                href="#" id="menuTransporte" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-truck"></i>&nbsp;&nbsp;Transporte
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="menuTransporte">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('truck-drivers.index') }}">Caminhoneiros</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('freights.index') }}">Fretes</a></li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown ms-auto">
                                            <a class="nav-link dropdown-toggle" href="#" id="userMenu"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->name }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        Sair
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>





                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <div id="content" class="flex-grow-1">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container-fluid" style="background-color: #363537">
            <div id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-6 align-self-center">
                            <p class="title-footer">WhatsApp:</p>
                            <p class="content-footer">(64) 9.9967-1030 <i class="fab fa-whatsapp"></i></p>
                        </div>
                        <div class="col-6 align-self-center">
                            <p class="title-footer">E-Mail:</p>
                            <p class="content-footer">lourivalvsjo@gmail.com.br</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="content-footer">Copyright © 2020 WebBoi - Todos os direitos reservados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        var dropdownElements = document.querySelectorAll('.dropdown-toggle');
        dropdownElements.forEach(function(dropdownToggleEl) {
            new bootstrap.Dropdown(dropdownToggleEl);
        });
    </script>


    <script>
        function mascaraCpfCnpj(field) {
            const v = field.value.replace(/\D/g, '');
            if (v.length <= 11) {
                field.value = v.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, function(_, a, b, c, d) {
                    return `${a}.${b}.${c}${d ? '-' + d : ''}`;
                });
            } else {
                field.value = v.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, function(_, a, b, c, d, e) {
                    return `${a}.${b}.${c}/${d}${e ? '-' + e : ''}`;
                });
            }
        }

        function mascaraTelefone(field) {
            const v = field.value.replace(/\D/g, '');
            if (v.length <= 10) {
                field.value = v.replace(/(\d{2})(\d{4})(\d{0,4})/, function(_, a, b, c) {
                    return `(${a}) ${b}${c ? '-' + c : ''}`;
                });
            } else {
                field.value = v.replace(/(\d{2})(\d{5})(\d{0,4})/, function(_, a, b, c) {
                    return `(${a}) ${b}${c ? '-' + c : ''}`;
                });
            }
        }
    </script>

</body>

</html>
