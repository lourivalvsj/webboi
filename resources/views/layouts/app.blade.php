<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - WebBoi</title>

    <link rel="sortcut icon" href="{{ asset('storage/img/favicon.png') }}" type="image/x-icon" />

    {{-- <!-- CSRF Token --> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <!-- Scripts --> --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" defer></script>
    <script src="{{ asset('js/js.js') }}" defer></script>

    {{-- <!-- Fonts --> --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- <!-- Icons --> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    {{-- <!-- Styles --> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link type="text/css" href=" {{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-white">
<header class="header header-with-topbar">
    <div class="container-fluid" style="background-color: #363537">
        <div class="row" style="height: 30px">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-12 d-flex justify-content-end">
                        <img src="{{ asset('storage/img/facebook-icon.png') }}" height="25px"
                             alt="Facebook">&nbsp;&nbsp;<img
                            src="{{ asset('storage/img/instagram-icon.png') }}" height="25px"
                            alt="Instagram">&nbsp;&nbsp;<img
                            src="{{ asset('storage/img/email-icon.png') }}" height="25px" alt="E-Mail">
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@guest
    <div class="container-fluid shadow-sm bg-white sticky-top">
        <div class="container bg-white">
            <div class="row d-flex align-items-center">
                <div class="col-4">
                    <a href="#"><span class="h2"><img class="py-1"
                                                      src="{{ asset('storage/img/logosis.png') }}" width="180px"></span></a>
                </div>
                <div class="col-8 d-flex justify-content-end">
                    <nav class="nav navbar-expand-md navbar-light bg-white">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false"
                                    aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarMenu">

                                <ul class="nav flex-row ">
                                    {{-- <li class="nav-item"> --}}
                                    {{-- <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i>&nbsp;&nbsp;Início</a> --}}
                                    {{-- </li> --}}
                                    {{-- <li class="nav-item"> --}}
                                    {{-- <a class="nav-link" href="#"><i class="fas fa-address-card"></i>&nbsp;&nbsp;Sobre</a> --}}
                                    {{-- </li> --}}
                                    {{-- <li class="nav-item dropdown"> --}}
                                    {{-- <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tasks"></i>&nbsp;&nbsp;Soluções</a> --}}
                                    {{-- <div class="dropdown-menu"> --}}
                                    {{-- <a class="dropdown-item" href="#">Vestiários/Lavanderias</a> --}}
                                    {{-- <a class="dropdown-item" href="#">Pizzarias/Lanches</a> --}}
                                    {{-- <a class="dropdown-item" href="#">Portaria/Controle de Acesso</a> --}}
                                    {{-- <div class="dropdown-divider"></div> --}}
                                    {{-- <a class="dropdown-item" href="#">Outros</a> --}}
                                    {{-- </div> --}}
                                    {{-- </li> --}}
                                    {{-- <li class="nav-item"> --}}
                                    {{-- <a class="nav-link" href="#"><i class="fas fa-user-tie"></i>&nbsp;&nbsp;Contato</a> --}}
                                    {{-- </li> --}}

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}"><i
                                                class="fas fa-user"></i>&nbsp;&nbsp;Login</a>
                                    </li>

                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>

                            </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endguest

@auth
    <div class="container-fluid shadow-sm bg-white sticky-top">
        <div class="container bg-white">
            <div class="row d-flex align-items-center">
                <div class="col-2">
                    <a href="#"><span class="h2"><img class="py-1"
                                                                        src="{{ asset('storage/img/logosis.png') }}" width="180px"></span></a>
                </div>
                <div class="col-10 d-flex justify-content-end">
                    <nav class="nav navbar-expand-md navbar-light bg-white">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false"
                                    aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarMenu">

                                <ul class="nav flex-row ">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i
                                                class="fas fa-home"></i>&nbsp;&nbsp;Início</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i
                                                class="fas fa-desktop"></i>&nbsp;&nbsp;Painel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i
                                                class="fas fa-desktop"></i>&nbsp;&nbsp;Comprador</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i
                                                class="fas fa-user-tie"></i>&nbsp;&nbsp;Usuarios</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i
                                                class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Finaceiro</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i
                                                class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Vendedor</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                                           role="button" aria-haspopup="true" aria-expanded="false"><i
                                                class="fas fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->name }}</a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                {{ __('Sair') }}
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

{{-- Conteúdo --}}
<div id="content">
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
                        <p class="content-footer">Copyright © 2020 WebBoi - Todos os direitos reservados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>

</html>
