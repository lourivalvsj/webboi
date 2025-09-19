@auth
<nav class="modern-navbar" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
    <div class="container">
        <div class="row align-items-center py-2">
            <div class="col-lg-2 col-md-3 col-6">
                <a href="{{ route('dashboard') }}" class="logo-container d-block">
                    <img class="img-fluid" 
                         src="{{ asset('img/WebBoiSemFundo.png') }}" 
                         alt="WebBoi" 
                         style="max-width: 180px; height: auto; width: 100%;">
                </a>
            </div>
            
            <div class="col-lg-10 col-md-9 col-6 d-flex justify-content-end" style="display: flex !important;">
                    <!-- Mobile Menu Button -->
                    <button class="navbar-toggler border-0 d-lg-none" 
                            type="button" 
                            onclick="openDrawer()"
                            aria-label="Abrir menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Desktop Navigation -->
                    <div class="w-100" style="display: block !important;">
                        <ul class="navbar-nav ms-auto d-flex flex-row align-items-center" style="display: flex !important;">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                   href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('animals*') || request()->is('animal-weights*') || request()->is('feedings*') || request()->is('medications*') || request()->is('purchases*') || request()->is('sales*') ? 'active' : '' }}"
                                   href="#" 
                                   id="menuAnimal" 
                                   role="button" 
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fas fa-cow"></i>Animais
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="menuAnimal">
                                    <li><a class="dropdown-item" href="{{ route('animals.index') }}">
                                        <i class="fas fa-list-ul me-2"></i>Gerenciar Animais</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('purchases.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>Compras</a></li>
                                    <li><a class="dropdown-item" href="{{ route('sales.index') }}">
                                        <i class="fas fa-chart-line me-2"></i>Vendas</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('animal-weights.index') }}">
                                        <i class="fas fa-weight me-2"></i>Pesagens</a></li>
                                    <li><a class="dropdown-item" href="{{ route('feedings.index') }}">
                                        <i class="fas fa-seedling me-2"></i>Alimentações</a></li>
                                    <li><a class="dropdown-item" href="{{ route('medications.index') }}">
                                        <i class="fas fa-pills me-2"></i>Medicações</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('vendors*') || request()->is('buyers*') || request()->is('categories*') || request()->is('locals*') ? 'active' : '' }}"
                                   href="#" 
                                   id="menuCadastros" 
                                   role="button" 
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fas fa-users"></i>Cadastros
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="menuCadastros">
                                    <li><a class="dropdown-item" href="{{ route('vendors.index') }}">
                                        <i class="fas fa-user-tie me-2"></i>Vendedores</a></li>
                                    <li><a class="dropdown-item" href="{{ route('buyers.index') }}">
                                        <i class="fas fa-handshake me-2"></i>Compradores</a></li>
                                    <li><a class="dropdown-item" href="{{ route('categories.index') }}">
                                        <i class="fas fa-tags me-2"></i>Categorias</a></li>
                                    <li><a class="dropdown-item" href="{{ route('locals.index') }}">
                                        <i class="fas fa-map-marker-alt me-2"></i>Locais</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('supply-expenses*') || request()->is('operational-expenses*') ? 'active' : '' }}"
                                   href="#" 
                                   id="menuDespesas" 
                                   role="button"
                                   data-bs-toggle="dropdown" 
                                   aria-expanded="false">
                                    <i class="fas fa-money-check-alt"></i>Despesas
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="menuDespesas">
                                    <li><a class="dropdown-item" href="{{ route('supply-expenses.index') }}">
                                        <i class="fas fa-box me-2"></i>Gastos com Insumos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('operational-expenses.index') }}">
                                        <i class="fas fa-cogs me-2"></i>Despesas Operacionais</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('truck-drivers*') || request()->is('freights*') ? 'active' : '' }}"
                                   href="#" 
                                   id="menuTransporte" 
                                   role="button"
                                   data-bs-toggle="dropdown" 
                                   aria-expanded="false">
                                    <i class="fas fa-truck"></i>Transporte
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="menuTransporte">
                                    <li><a class="dropdown-item" href="{{ route('truck-drivers.index') }}">
                                        <i class="fas fa-id-card me-2"></i>Caminhoneiros</a></li>
                                    <li><a class="dropdown-item" href="{{ route('freights.index') }}">
                                        <i class="fas fa-shipping-fast me-2"></i>Fretes</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-menu" 
                                   href="#" 
                                   id="userMenu"
                                   role="button" 
                                   data-bs-toggle="dropdown" 
                                   aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>{{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Sair
                                    </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@else
    <!-- DEBUG: User not authenticated -->
    <div style="background: red; color: white; padding: 10px;">
        DEBUG: Usuário não autenticado
    </div>
@endauth
<!-- DEBUG: Navigation End -->
