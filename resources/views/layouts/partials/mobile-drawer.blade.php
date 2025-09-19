@auth
<div class="mobile-drawer" id="mobileDrawer" role="navigation" aria-label="Menu principal">
    <div class="drawer-header">
        <button class="drawer-close" 
                onclick="closeDrawer()" 
                aria-label="Fechar menu">
            <i class="fas fa-times"></i>
        </button>
        <img src="{{ asset('img/WebBoiSemFundo.png') }}" 
             alt="WebBoi" 
             class="img-fluid">
    </div>
    
    <nav class="drawer-nav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}" 
                   onclick="closeDrawer()">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="#" 
                   onclick="toggleSubmenu('animalsSubmenu', this)"
                   aria-expanded="false">
                    <i class="fas fa-cow"></i>Animais
                    <i class="fas fa-chevron-down drawer-toggle"></i>
                </a>
                <ul class="drawer-submenu" id="animalsSubmenu">
                    <li><a class="nav-link" href="{{ route('animals.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-list-ul"></i>Gerenciar Animais</a></li>
                    <li><div class="submenu-divider"></div></li>
                    <li><a class="nav-link" href="{{ route('purchases.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-shopping-cart"></i>Compras</a></li>
                    <li><a class="nav-link" href="{{ route('sales.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-chart-line"></i>Vendas</a></li>
                    <li><div class="submenu-divider"></div></li>
                    <li><a class="nav-link" href="{{ route('animal-weights.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-weight"></i>Pesagens</a></li>
                    <li><a class="nav-link" href="{{ route('feedings.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-seedling"></i>Alimentações</a></li>
                    <li><a class="nav-link" href="{{ route('medications.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-pills"></i>Medicações</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="#" 
                   onclick="toggleSubmenu('cadastrosSubmenu', this)"
                   aria-expanded="false">
                    <i class="fas fa-users"></i>Cadastros
                    <i class="fas fa-chevron-down drawer-toggle"></i>
                </a>
                <ul class="drawer-submenu" id="cadastrosSubmenu">
                    <li><a class="nav-link" href="{{ route('vendors.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-user-tie"></i>Vendedores</a></li>
                    <li><a class="nav-link" href="{{ route('buyers.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-handshake"></i>Compradores</a></li>
                    <li><a class="nav-link" href="{{ route('categories.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-tags"></i>Categorias</a></li>
                    <li><a class="nav-link" href="{{ route('locals.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-map-marker-alt"></i>Locais</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="#" 
                   onclick="toggleSubmenu('despesasSubmenu', this)"
                   aria-expanded="false">
                    <i class="fas fa-money-check-alt"></i>Despesas
                    <i class="fas fa-chevron-down drawer-toggle"></i>
                </a>
                <ul class="drawer-submenu" id="despesasSubmenu">
                    <li><a class="nav-link" href="{{ route('supply-expenses.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-box"></i>Gastos com Insumos</a></li>
                    <li><a class="nav-link" href="{{ route('operational-expenses.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-cogs"></i>Despesas Operacionais</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="#" 
                   onclick="toggleSubmenu('transporteSubmenu', this)"
                   aria-expanded="false">
                    <i class="fas fa-truck"></i>Transporte
                    <i class="fas fa-chevron-down drawer-toggle"></i>
                </a>
                <ul class="drawer-submenu" id="transporteSubmenu">
                    <li><a class="nav-link" href="{{ route('truck-drivers.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-id-card"></i>Caminhoneiros</a></li>
                    <li><a class="nav-link" href="{{ route('freights.index') }}" onclick="closeDrawer()">
                        <i class="fas fa-shipping-fast"></i>Fretes</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" 
                   href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>Sair
                </a>
            </li>
        </ul>
    </nav>
</div>
@endauth
