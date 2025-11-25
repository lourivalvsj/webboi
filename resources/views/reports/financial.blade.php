@extends('layouts.app')

@section('title', 'Relatório Financeiro')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-2">💰 Relatório Financeiro</h1>
            <p class="text-muted mb-0">Análise completa de receitas, despesas e resultados</p>
        </div>
        <div>
            <button type="button" class="btn btn-success btn-modern" onclick="exportReport()">
                <i class="fas fa-file-pdf me-2"></i>Exportar PDF
            </button>
        </div>
    </div>

    <!-- Filtros de Período -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-calendar me-2"></i>Período de Análise</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.financial') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Data Inicial</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ request('start_date', $period['start']) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data Final</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ request('end_date', $period['end']) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-modern w-100">
                        <i class="fas fa-chart-line me-2"></i>Gerar Relatório
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumo Financeiro -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card financial-card revenue-card text-white">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-up fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($revenue['total'], 2, ',', '.') }}</h4>
                    <small>Total de Receitas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card financial-card expense-card text-white">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-down fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($expenses['total'], 2, ',', '.') }}</h4>
                    <small>Total de Despesas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card financial-card {{ $profit_loss >= 0 ? 'profit-card' : 'loss-card' }} text-white">
                <div class="card-body text-center">
                    <i class="fas fa-{{ $profit_loss >= 0 ? 'trophy' : 'exclamation-triangle' }} fa-2x mb-2"></i>
                    <h4>{{ $profit_loss >= 0 ? 'R$ ' : '-R$ ' }}{{ number_format(abs($profit_loss), 2, ',', '.') }}</h4>
                    <small>{{ $profit_loss >= 0 ? 'Lucro' : 'Prejuízo' }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card financial-card margin-card text-dark">
                <div class="card-body text-center">
                    <i class="fas fa-percentage fa-2x mb-2"></i>
                    <h4>{{ number_format($profit_margin, 1) }}%</h4>
                    <small>Margem de Lucro</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalhamento de Receitas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-line me-2"></i>Receitas - Vendas</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Animal</th>
                                <th>Comprador</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenue['sales']->take(10) as $sale)
                            <tr>
                                <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                <td>#{{ $sale->animal->id ?? '-' }}</td>
                                <td>{{ $sale->buyer->name ?? '-' }}</td>
                                <td class="text-end fw-bold">R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Nenhuma venda no período
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($revenue['sales']->count() > 10)
                <div class="card-footer text-center">
                    <small class="text-muted">... e mais {{ $revenue['sales']->count() - 10 }} vendas</small>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Detalhamento de Despesas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-pie me-2"></i>Breakdown de Despesas</h5>
                </div>
                <div class="card-body">
                    <div class="expense-item mb-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-shopping-cart me-2 text-primary"></i>Compras de Animais</span>
                            <span class="fw-bold">R$ {{ number_format($expenses['purchases']['total'], 2, ',', '.') }}</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-primary" style="width: {{ $expenses['total'] > 0 ? ($expenses['purchases']['total'] / $expenses['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="expense-item mb-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-box me-2 text-warning"></i>Suprimentos</span>
                            <span class="fw-bold">R$ {{ number_format($expenses['supplies']['total'], 2, ',', '.') }}</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-warning" style="width: {{ $expenses['total'] > 0 ? ($expenses['supplies']['total'] / $expenses['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="expense-item mb-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-cogs me-2 text-info"></i>Despesas Operacionais</span>
                            <span class="fw-bold">R$ {{ number_format($expenses['operational']['total'], 2, ',', '.') }}</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-info" style="width: {{ $expenses['total'] > 0 ? ($expenses['operational']['total'] / $expenses['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="expense-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-truck me-2 text-success"></i>Fretes</span>
                            <span class="fw-bold">R$ {{ number_format($expenses['freights']['total'], 2, ',', '.') }}</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-success" style="width: {{ $expenses['total'] > 0 ? ($expenses['freights']['total'] / $expenses['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.financial-card {
    border-radius: 12px;
    border: none;
    transition: transform 0.3s ease;
}

.financial-card:hover {
    transform: translateY(-5px);
}

.revenue-card {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.expense-card {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.profit-card {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
}

.loss-card {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
}

.margin-card {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.expense-item .progress {
    height: 4px;
}

.card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

.btn-modern {
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}
</style>

<script>
function exportReport() {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('export', 'pdf');
    window.open(currentUrl.toString(), '_blank');
}
</script>
@endsection