<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - WebBoi</title>

    <link rel="sortcut icon" href="{{ asset('storage/img/favicon.png') }}" type="image/x-icon" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" defer></script>
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
                            <img src="{{ asset('storage/img/facebook-icon.png') }}" height="25px" alt="Facebook">
                            &nbsp;&nbsp;<img src="{{ asset('storage/img/instagram-icon.png') }}" height="25px"
                                alt="Instagram">
                            &nbsp;&nbsp;<img src="{{ asset('storage/img/email-icon.png') }}" height="25px"
                                alt="E-Mail">
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
                        <a href="{{ route('dashboard') }}"><img class="py-1" src="{{ asset('storage/img/logosis.png') }}"
                                width="180px"></a>
                    </div>
                    <div class="col-10 d-flex justify-content-end">
                        <nav class="nav navbar-expand-md navbar-light bg-white">
                            <div class="container">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarMenu">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarMenu">
                                    <ul class="nav flex-row">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('dashboard') }}"><i
                                                    class="fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('animals.index') }}"><i
                                                    class="fas fa-cow"></i>&nbsp;&nbsp;Animais</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('purchases.index') }}"><i
                                                    class="fas fa-cart-plus"></i>&nbsp;&nbsp;Compras</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('sales.index') }}"><i
                                                    class="fas fa-shopping-basket"></i>&nbsp;&nbsp;Vendas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('vendors.index') }}"><i
                                                    class="fas fa-user-tie"></i>&nbsp;&nbsp;Vendedores</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('buyers.index') }}"><i
                                                    class="fas fa-user-tag"></i>&nbsp;&nbsp;Compradores</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('categories.index') }}"><i
                                                    class="fas fa-tags"></i>&nbsp;&nbsp;Categorias</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                                role="button">
                                                <i class="fas fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->name }}
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Sair
                                                </a>
                                            </div>
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
