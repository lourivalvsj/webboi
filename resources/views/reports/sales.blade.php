@extends('layouts.app')

@section('title', 'Relatório de Vendas')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-2">📈 Relatório de Vendas</h1>
            <p class="text-muted mb-0">Análise detalhada das vendas realizadas</p>
        </div>
        <div>
            <button type="button" class="btn btn-success btn-modern" onclick="exportReport()">
                <i class="fas fa-file-pdf me-2"></i>Exportar PDF
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-filter me-2"></i>Filtros de Busca</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.sales') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Comprador</label>
                    <select name="buyer_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach(\App\Models\Buyer::all() as $buyer)
                            <option value="{{ $buyer->id }}" {{ request('buyer_id') == $buyer->id ? 'selected' : '' }}>
                                {{ $buyer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Data Inicial</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Data Final</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Valor Mín.</label>
                    <input type="number" name="min_value" class="form-control" step="0.01" 
                           placeholder="R$ 0,00" value="{{ request('min_value') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Valor Máx.</label>
                    <input type="number" name="max_value" class="form-control" step="0.01" 
                           placeholder="R$ 0,00" value="{{ request('max_value') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-modern w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-handshake fa-2x mb-2"></i>
                    <h4>{{ $stats['total_sales'] }}</h4>
                    <small>Total de Vendas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</h4>
                    <small>Receita Total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['average_sale_value'], 2, ',', '.') }}</h4>
                    <small>Venda Média</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-trophy fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['best_sale'], 2, ',', '.') }}</h4>
                    <small>Melhor Venda</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-weight fa-2x mb-2"></i>
                    <h4>{{ number_format($stats['total_weight_sold'], 0) }}kg</h4>
                    <small>Peso Total</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Vendas -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Vendas Realizadas - {{ $sales->total() }} registros</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover modern-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar me-2"></i>Data</th>
                        <th><i class="fas fa-cow me-2"></i>Animal</th>
                        <th><i class="fas fa-tags me-2"></i>Categoria</th>
                        <th><i class="fas fa-user me-2"></i>Comprador</th>
                        <th><i class="fas fa-weight me-2"></i>Peso</th>
                        <th><i class="fas fa-dollar-sign me-2"></i>Valor</th>
                        <th><i class="fas fa-calculator me-2"></i>Preço/kg</th>
                        <th><i class="fas fa-chart-line me-2"></i>Margem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    @php
                        $pricePerKg = $sale->weight_at_sale > 0 ? $sale->value / $sale->weight_at_sale : 0;
                        $purchaseValue = $sale->animal && $sale->animal->purchase ? $sale->animal->purchase->value : 0;
                        $profit = $sale->value - $purchaseValue;
                        $margin = $purchaseValue > 0 ? ($profit / $purchaseValue) * 100 : 0;
                    @endphp
                    <tr>
                        <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                        <td class="fw-bold">#{{ $sale->animal->id ?? '-' }}</td>
                        <td>
                            <span class="text-muted">{{ $sale->animal->category->name ?? 'N/A' }}</span>
                        </td>
                        <td>{{ $sale->buyer->name ?? 'N/A' }}</td>
                        <td>{{ number_format($sale->weight_at_sale, 1) }}kg</td>
                        <td class="fw-bold text-success">R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($pricePerKg, 2, ',', '.') }}/kg</td>
                        <td>
                            <span class="badge {{ $margin >= 10 ? 'bg-success' : ($margin >= 0 ? 'bg-warning' : 'bg-danger') }}">
                                {{ number_format($margin, 1) }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <br>Nenhuma venda encontrada com os filtros aplicados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sales->hasPages())
        <div class="card-footer">
            {{ $sales->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.btn-modern {
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}

.stats-card {
    border-radius: 12px;
    border: none;
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.modern-table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-weight: 600;
}

.modern-table tbody td {
    border: none;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
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