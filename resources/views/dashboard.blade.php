@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="text-center fw-bold text-dark mb-1">Dashboard</h2>
                    <p class="text-center text-muted">Visão geral do seu sistema de gestão pecuária</p>
                </div>
            </div>

            <div class="row g-3">
                <!-- Card Total Animals -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card dashboard-card animals-card h-100 border-0 shadow-lg">
                        <div class="card-body text-center position-relative">
                            <div class="icon-container mb-3">
                                <i class="fas fa-cow fa-2x text-white"></i>
                            </div>
                            <h6 class="card-title text-white mb-2 fw-semibold">Total de Animais</h6>
                            <h2 class="card-number text-white fw-bold mb-0">{{ $totalAnimals ?? 0 }}</h2>
                            <div class="card-animation"></div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Purchases -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card dashboard-card purchases-card h-100 border-0 shadow-lg">
                        <div class="card-body text-center position-relative">
                            <div class="icon-container mb-3">
                                <i class="fas fa-shopping-cart fa-2x text-white"></i>
                            </div>
                            <h6 class="card-title text-white mb-2 fw-semibold">Total de Compras</h6>
                            <h2 class="card-number text-white fw-bold mb-0">{{ $totalPurchases ?? 0 }}</h2>
                            <div class="card-animation"></div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Sales -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card dashboard-card sales-card h-100 border-0 shadow-lg">
                        <div class="card-body text-center position-relative">
                            <div class="icon-container mb-3">
                                <i class="fas fa-chart-line fa-2x text-white"></i>
                            </div>
                            <h6 class="card-title text-white mb-2 fw-semibold">Total de Vendas</h6>
                            <h2 class="card-number text-white fw-bold mb-0">{{ $totalSales ?? 0 }}</h2>
                            <div class="card-animation"></div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Spent -->
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card dashboard-card expenses-card h-100 border-0 shadow-lg">
                        <div class="card-body text-center position-relative">
                            <div class="icon-container mb-3">
                                <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                            </div>
                            <h6 class="card-title text-white mb-2 fw-semibold">Total Gasto</h6>
                            <h3 class="card-number-small text-white fw-bold mb-0">R$ {{ number_format($totalSpent ?? 0, 2, ',', '.') }}</h3>
                            <div class="card-animation"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Lucro/Prejuízo na mesma linha -->
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card dashboard-card {{ ($profitLoss ?? 0) >= 0 ? 'profit-card' : 'loss-card' }} h-100 border-0 shadow-lg">
                        <div class="card-body text-center position-relative">
                            <div class="icon-container mb-3">
                                <i class="fas fa-{{ ($profitLoss ?? 0) >= 0 ? 'chart-line' : 'chart-line-down' }} fa-2x text-white"></i>
                            </div>
                            <h6 class="card-title text-white mb-2 fw-semibold">{{ ($profitLoss ?? 0) >= 0 ? 'Lucro' : 'Prejuízo' }}</h6>
                            <h3 class="card-number-small text-white fw-bold mb-0">
                                {{ ($profitLoss ?? 0) >= 0 ? 'R$ ' : '-R$ ' }}{{ number_format(abs($profitLoss ?? 0), 2, ',', '.') }}
                            </h3>
                            <div class="card-animation"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.dashboard-card {
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
}

.animals-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.purchases-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.sales-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.expenses-card {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.profit-card {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.loss-card {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.icon-container {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    margin: 0 auto;
    transition: all 0.3s ease;
}

.dashboard-card:hover .icon-container {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.3);
}

.card-number {
    font-size: 2.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.card-number-small {
    font-size: 1.8rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.card-title {
    font-size: 0.95rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    opacity: 0.95;
}

.card-animation {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    transition: all 0.6s ease;
    opacity: 0;
}

.dashboard-card:hover .card-animation {
    opacity: 1;
    transform: scale(1.5);
}

/* Animação de entrada */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dashboard-card {
    animation: fadeInUp 0.6s ease forwards;
}

.dashboard-card:nth-child(1) { animation-delay: 0.1s; }
.dashboard-card:nth-child(2) { animation-delay: 0.2s; }
.dashboard-card:nth-child(3) { animation-delay: 0.3s; }
.dashboard-card:nth-child(4) { animation-delay: 0.4s; }
.dashboard-card:nth-child(5) { animation-delay: 0.5s; }

/* Responsive Design */
@media (max-width: 768px) {
    .card-number {
        font-size: 2rem;
    }
    
    .card-number-small {
        font-size: 1.5rem;
    }
    
    .icon-container {
        width: 60px;
        height: 60px;
    }
    
    .icon-container i {
        font-size: 1.5rem !important;
    }
    
    .card-title {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .card-number {
        font-size: 1.5rem;
    }
    
    .card-number-small {
        font-size: 1.2rem;
    }
    
    .icon-container {
        width: 50px;
        height: 50px;
    }
    
    .icon-container i {
        font-size: 1.2rem !important;
    }
    
    .card-title {
        font-size: 0.8rem;
        margin-bottom: 8px !important;
    }
    
    .card-body {
        padding: 15px;
    }
    
    .dashboard-card {
        border-radius: 15px;
    }
}

@media (max-width: 480px) {
    .card-number {
        font-size: 1.3rem;
    }
    
    .card-number-small {
        font-size: 1rem;
    }
    
    .icon-container {
        width: 45px;
        height: 45px;
        margin-bottom: 10px !important;
    }
    
    .icon-container i {
        font-size: 1rem !important;
    }
    
    .card-title {
        font-size: 0.75rem;
    }
    
    .card-body {
        padding: 12px;
    }
}

@media (max-width: 380px) {
    .card-number {
        font-size: 1.1rem;
    }
    
    .card-number-small {
        font-size: 0.9rem;
    }
    
    .card-title {
        font-size: 0.7rem;
        line-height: 1.2;
    }
    
    .icon-container {
        width: 40px;
        height: 40px;
    }
    
    .icon-container i {
        font-size: 0.9rem !important;
    }
    
    .card-body {
        padding: 10px;
    }
    
    .dashboard-card {
        border-radius: 12px;
    }
}
</style>
@endpush
