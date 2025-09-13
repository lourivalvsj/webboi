<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'WebBoi') - Sistema de Gestão Pecuária</title>
    <meta name="description" content="Sistema completo de gestão pecuária - WebBoi">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/img/favicon.png') }}" type="image/x-icon">
    
    <!-- Preconnect para melhor performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    @include('layouts.partials.styles')
    
    @stack('styles')
</head>

<body class="antialiased">
    <!-- Loading Spinner -->
    <div id="loading-spinner" class="loading-spinner">
        <div class="spinner"></div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div class="mobile-drawer-overlay" onclick="closeDrawer()"></div>
    
    <!-- Mobile Drawer -->
    @include('layouts.partials.mobile-drawer')
    
    <!-- Header -->
    @include('layouts.partials.header')
    
    <!-- Navigation -->
    @include('layouts.partials.navigation')
    
    <!-- Main Content -->
    <main id="main-content" class="main-content">
        <!-- Page Header -->
        @hasSection('page-header')
            <section class="page-header">
                <div class="container">
                    @yield('page-header')
                </div>
            </section>
        @endif
        
        <!-- Breadcrumbs -->
        @hasSection('breadcrumbs')
            <nav class="breadcrumbs" aria-label="breadcrumb">
                <div class="container">
                    @yield('breadcrumbs')
                </div>
            </nav>
        @endif
        
        <!-- Flash Messages -->
        @include('layouts.partials.flash-messages')
        
        <!-- Page Content -->
        <section class="page-content">
            @yield('content')
        </section>
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    <!-- Mobile Drawer -->
    @include('layouts.partials.mobile-drawer')
    
    <!-- Logout Form -->
    @auth
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endauth
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Custom Scripts -->
    @include('layouts.partials.scripts')
    
    @stack('scripts')
    
    <!-- Performance Monitoring -->
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loading-spinner').style.display = 'none';
        });
    </script>
</body>

</html>
