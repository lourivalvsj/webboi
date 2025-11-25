@extends('layouts.app')

@section('title', 'Dashboard Lucro/Prejuízo')

@section('styles')
<style>
    .profit-card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .profit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .loss-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .revenue-card {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .expenses-card {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .margin-card {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #2c3e50 !important;
    }

    .financial-icon {
        font-size: 3.5rem;
        opacity: 0.8;
        margin-bottom: 1rem;
    }

    .period-selector {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .top-animals-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
    }

    .table-modern td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .profit-positive {
        color: #28a745;
        font-weight: bold;
    }

    .profit-negative {
        color: #dc3545;
        font-weight: bold;
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 40px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    .btn-modern {
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary.btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-primary.btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .expense-breakdown {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .expense-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .expense-item:last-child {
        border-bottom: none;
    }

    .expense-label {
        font-weight: 500;
        color: #495057;
    }

    .expense-value {
        font-weight: bold;
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
        <div>
            <h1 class="h2 text-primary mb-2">💰 Dashboard Lucro/Prejuízo</h1>
            <p class="text-muted mb-0">Análise financeira completa do seu negócio</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary btn-modern" onclick="exportReport()">
                <i class="fas fa-download me-2"></i>Exportar Relatório
            </button>
        </div>
    </div>

    <!-- Seletor de Período -->
    <div class="period-selector fade-in-up" style="animation-delay: 0.1s;">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">Data Inicial</label>
                <input type="date" class="form-control" id="startDate" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Data Final</label>
                <input type="date" class="form-control" id="endDate" value="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Filtros Rápidos</label>
                <select class="form-select" id="quickPeriod" onchange="setQuickPeriod()">
                    <option value="">Período personalizado</option>
                    <option value="today">Hoje</option>
                    <option value="week">Esta semana</option>
                    <option value="month" selected>Este mês</option>
                    <option value="quarter">Este trimestre</option>
                    <option value="year">Este ano</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary btn-modern w-100" onclick="updateDashboard()">
                    <i class="fas fa-chart-line me-2"></i>Atualizar
                </button>
            </div>
        </div>
    </div>

    <!-- Cards Principais -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card profit-card revenue-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line financial-icon"></i>
                    <h6 class="card-subtitle mb-2">Receita Total</h6>
                    <h3 class="card-title mb-0" id="totalRevenue">R$ {{ number_format($financialData['totalRevenue'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card profit-card expenses-card fade-in-up" style="animation-delay: 0.3s;">
                <div class="card-body text-center">
                    <i class="fas fa-chart-pie financial-icon"></i>
                    <h6 class="card-subtitle mb-2">Despesas Totais</h6>
                    <h3 class="card-title mb-0" id="totalExpenses">R$ {{ number_format($financialData['totalExpenses'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card profit-card {{ $financialData['netProfit'] >= 0 ? 'profit-card' : 'loss-card' }} fade-in-up" style="animation-delay: 0.4s;">
                <div class="card-body text-center">
                    <i class="fas fa-{{ $financialData['netProfit'] >= 0 ? 'arrow-trend-up' : 'arrow-trend-down' }} financial-icon"></i>
                    <h6 class="card-subtitle mb-2">{{ $financialData['netProfit'] >= 0 ? 'Lucro Líquido' : 'Prejuízo' }}</h6>
                    <h3 class="card-title mb-0" id="netProfit">
                        {{ $financialData['netProfit'] >= 0 ? 'R$ ' : '-R$ ' }}{{ number_format(abs($financialData['netProfit']), 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card profit-card margin-card fade-in-up" style="animation-delay: 0.5s;">
                <div class="card-body text-center">
                    <i class="fas fa-percentage financial-icon"></i>
                    <h6 class="card-subtitle mb-2">Margem de Lucro</h6>
                    <h3 class="card-title mb-0" id="profitMargin">{{ number_format($financialData['profitMargin'], 1) }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Análises -->
    <div class="row">
        <!-- Gráfico de Evolução Mensal -->
        <div class="col-lg-8 mb-4">
            <div class="chart-container fade-in-up" style="animation-delay: 0.6s;">
                <h5 class="mb-4"><i class="fas fa-chart-area text-primary me-2"></i>Evolução Financeira Mensal</h5>
                <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Breakdown de Despesas -->
        <div class="col-lg-4 mb-4">
            <div class="expense-breakdown fade-in-up" style="animation-delay: 0.7s;">
                <h5 class="mb-4"><i class="fas fa-calculator text-primary me-2"></i>Breakdown de Despesas</h5>
                
                <div class="expense-item">
                    <span class="expense-label">Compras de Animais</span>
                    <span class="expense-value">R$ {{ number_format($expenseBreakdown['purchases'], 2, ',', '.') }}</span>
                </div>
                
                <div class="expense-item">
                    <span class="expense-label">Suprimentos</span>
                    <span class="expense-value">R$ {{ number_format($expenseBreakdown['supplies'], 2, ',', '.') }}</span>
                </div>
                
                <div class="expense-item">
                    <span class="expense-label">Operacionais</span>
                    <span class="expense-value">R$ {{ number_format($expenseBreakdown['operational'], 2, ',', '.') }}</span>
                </div>
                
                <div class="expense-item">
                    <span class="expense-label">Fretes</span>
                    <span class="expense-value">R$ {{ number_format($expenseBreakdown['freights'], 2, ',', '.') }}</span>
                </div>
                
                <hr>
                <div class="expense-item">
                    <span class="expense-label fw-bold">Total Geral</span>
                    <span class="expense-value fw-bold fs-5">R$ {{ number_format($financialData['totalExpenses'], 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Animais Mais Lucrativos -->
    <div class="row">
        <div class="col-12">
            <div class="top-animals-table fade-in-up" style="animation-delay: 0.8s;">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="mb-0"><i class="fas fa-trophy text-warning me-2"></i>Top 10 - Animais Mais Lucrativos</h5>
                    <small class="text-muted">Baseado no lucro líquido por animal</small>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>Posição</th>
                                <th><i class="fas fa-tag me-2"></i>ID Animal</th>
                                <th><i class="fas fa-shopping-cart me-2"></i>Custo Compra</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Valor Venda</th>
                                <th><i class="fas fa-receipt me-2"></i>Gastos Extras</th>
                                <th><i class="fas fa-chart-line me-2"></i>Lucro Líquido</th>
                                <th><i class="fas fa-percentage me-2"></i>Margem</th>
                            </tr>
                        </thead>
                        <tbody id="topAnimalsTable">
                            @foreach($topAnimals as $index => $animal)
                            <tr>
                                <td>
                                    @if($index === 0)
                                        <i class="fas fa-crown text-warning me-2"></i>{{ $index + 1 }}º
                                    @elseif($index === 1)
                                        <i class="fas fa-medal text-secondary me-2"></i>{{ $index + 1 }}º
                                    @elseif($index === 2)
                                        <i class="fas fa-award text-warning me-2"></i>{{ $index + 1 }}º
                                    @else
                                        {{ $index + 1 }}º
                                    @endif
                                </td>
                                <td class="fw-bold">#{{ $animal['id'] }}</td>
                                <td>R$ {{ number_format($animal['purchase_cost'], 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($animal['sale_value'], 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($animal['extra_costs'], 2, ',', '.') }}</td>
                                <td class="{{ $animal['net_profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                    {{ $animal['net_profit'] >= 0 ? 'R$ ' : '-R$ ' }}{{ number_format(abs($animal['net_profit']), 2, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge {{ $animal['margin'] >= 10 ? 'bg-success' : ($animal['margin'] >= 0 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ number_format($animal['margin'], 1) }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Dados para o gráfico mensal
    const monthlyData = @json($monthlyData);
    
    // Configuração do gráfico
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [
                {
                    label: 'Receitas',
                    data: monthlyData.map(item => item.revenue),
                    backgroundColor: 'rgba(79, 172, 254, 0.1)',
                    borderColor: 'rgba(79, 172, 254, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Despesas',
                    data: monthlyData.map(item => item.expenses),
                    backgroundColor: 'rgba(250, 112, 154, 0.1)',
                    borderColor: 'rgba(250, 112, 154, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Lucro Líquido',
                    data: monthlyData.map(item => item.profit),
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': R$ ' + 
                                   new Intl.NumberFormat('pt-BR', {
                                       minimumFractionDigits: 2,
                                       maximumFractionDigits: 2
                                   }).format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + new Intl.NumberFormat('pt-BR', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Função para definir períodos rápidos
    function setQuickPeriod() {
        const select = document.getElementById('quickPeriod');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        const today = new Date();
        
        switch(select.value) {
            case 'today':
                startDate.value = today.toISOString().split('T')[0];
                endDate.value = today.toISOString().split('T')[0];
                break;
            case 'week':
                const weekStart = new Date(today.setDate(today.getDate() - today.getDay()));
                startDate.value = weekStart.toISOString().split('T')[0];
                endDate.value = new Date().toISOString().split('T')[0];
                break;
            case 'month':
                const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                startDate.value = monthStart.toISOString().split('T')[0];
                endDate.value = new Date().toISOString().split('T')[0];
                break;
            case 'quarter':
                const quarter = Math.floor(today.getMonth() / 3);
                const quarterStart = new Date(today.getFullYear(), quarter * 3, 1);
                startDate.value = quarterStart.toISOString().split('T')[0];
                endDate.value = new Date().toISOString().split('T')[0];
                break;
            case 'year':
                const yearStart = new Date(today.getFullYear(), 0, 1);
                startDate.value = yearStart.toISOString().split('T')[0];
                endDate.value = new Date().toISOString().split('T')[0];
                break;
        }
    }

    // Função para atualizar o dashboard via AJAX
    function updateDashboard() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            alert('Por favor, selecione ambas as datas.');
            return;
        }
        
        // Mostrar loading
        document.querySelector('.container-fluid').style.opacity = '0.5';
        
        // Requisição AJAX para atualizar dados
        fetch(`{{ route('profit-loss.period') }}?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                // Atualizar cards
                document.getElementById('totalRevenue').textContent = 'R$ ' + 
                    new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2}).format(data.totalRevenue);
                document.getElementById('totalExpenses').textContent = 'R$ ' + 
                    new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2}).format(data.totalExpenses);
                document.getElementById('netProfit').textContent = 
                    (data.netProfit >= 0 ? 'R$ ' : '-R$ ') + 
                    new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2}).format(Math.abs(data.netProfit));
                document.getElementById('profitMargin').textContent = 
                    new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 1}).format(data.profitMargin) + '%';
                
                // Remover loading
                document.querySelector('.container-fluid').style.opacity = '1';
            })
            .catch(error => {
                console.error('Erro ao atualizar dashboard:', error);
                document.querySelector('.container-fluid').style.opacity = '1';
                alert('Erro ao atualizar os dados. Tente novamente.');
            });
    }

    // Função para exportar relatório
    function exportReport() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            alert('Por favor, selecione o período para exportar.');
            return;
        }
        
        // Criar URL para download
        const url = `{{ route('profit-loss.index') }}?export=pdf&start_date=${startDate}&end_date=${endDate}`;
        window.open(url, '_blank');
    }

    // Inicializar com período atual selecionado
    document.addEventListener('DOMContentLoaded', function() {
        setQuickPeriod();
    });
</script>
@endsection