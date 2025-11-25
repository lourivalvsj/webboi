@extends('layouts.app')

@section('title', 'Relatório de Compras')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-2">🛒 Relatório de Compras</h1>
            <p class="text-muted mb-0">Análise detalhada das compras realizadas</p>
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
            <form method="GET" action="{{ route('reports.purchases') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Vendedor</label>
                    <select name="vendor_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach(\App\Models\Vendor::all() as $vendor)
                            <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
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
                    <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                    <h4>{{ $stats['total_purchases'] }}</h4>
                    <small>Total de Compras</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['total_spent'], 2, ',', '.') }}</h4>
                    <small>Total Investido</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['average_purchase_value'], 2, ',', '.') }}</h4>
                    <small>Compra Média</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['highest_purchase'], 2, ',', '.') }}</h4>
                    <small>Maior Compra</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-cow fa-2x mb-2"></i>
                    <h4>{{ number_format($stats['total_animals_purchased'], 0) }}</h4>
                    <small>Animais Comprados</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Compras -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Compras Realizadas - {{ $purchases->total() }} registros</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover modern-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar me-2"></i>Data</th>
                        <th><i class="fas fa-cow me-2"></i>Animal</th>
                        <th><i class="fas fa-tags me-2"></i>Categoria</th>
                        <th><i class="fas fa-user-tie me-2"></i>Vendedor</th>
                        <th><i class="fas fa-weight me-2"></i>Peso</th>
                        <th><i class="fas fa-dollar-sign me-2"></i>Valor</th>
                        <th><i class="fas fa-calculator me-2"></i>Preço/kg</th>
                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                    @php
                        $animalWeight = $purchase->animal?->animalWeights?->first()?->weight ?? 0;
                        $pricePerKg = $animalWeight > 0 ? $purchase->value / $animalWeight : 0;
                        $isActive = $purchase->animal && !$purchase->animal->sale;
                    @endphp
                    <tr>
                        <td>{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                        <td class="fw-bold">#{{ $purchase->animal->id ?? '-' }}</td>
                        <td>
                            <span class="text-muted">{{ $purchase->animal->category->name ?? 'N/A' }}</span>
                        </td>
                        <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $purchase->animal?->animalWeights?->first() ? number_format($purchase->animal->animalWeights->first()->weight, 1) . 'kg' : 'N/A' }}</td>
                        <td class="fw-bold text-danger">R$ {{ number_format($purchase->value, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($pricePerKg, 2, ',', '.') }}/kg</td>
                        <td>
                            @if($isActive)
                                <span class="text-success fw-bold">Ativo</span>
                            @else
                                <span class="text-info fw-bold">Vendido</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <br>Nenhuma compra encontrada com os filtros aplicados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($purchases->hasPages())
        <div class="card-footer">
            {{ $purchases->withQueryString()->links() }}
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