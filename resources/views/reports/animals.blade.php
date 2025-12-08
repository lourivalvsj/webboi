@extends('layouts.app')

@section('title', 'Relatório de Animais')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-2">🐄 Relatório de Animais</h1>
            <p class="text-muted mb-0">Análise completa do rebanho e histórico dos animais</p>
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
            <form method="GET" action="{{ route('reports.animals') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Categoria</label>
                    <select name="category_id" class="form-select">
                        <option value="">Todas as categorias</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="vendido" {{ request('status') == 'vendido' ? 'selected' : '' }}>Vendido</option>
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
                    <i class="fas fa-cow fa-2x mb-2"></i>
                    <h4>{{ $stats['total_animals'] }}</h4>
                    <small>Total de Animais</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-heart fa-2x mb-2"></i>
                    <h4>{{ $stats['active_animals'] }}</h4>
                    <small>Animais Ativos</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-handshake fa-2x mb-2"></i>
                    <h4>{{ $stats['sold_animals'] }}</h4>
                    <small>Animais Vendidos</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-weight fa-2x mb-2"></i>
                    <h4>{{ number_format($stats['average_weight'] ?? 0, 1) }}kg</h4>
                    <small>Peso Médio</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-balance-scale fa-2x mb-2"></i>
                    <h4>{{ number_format($stats['total_weight'] ?? 0, 0) }}kg</h4>
                    <small>Peso Total</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Animais -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Listagem Detalhada - {{ $animals->total() }} animais encontrados</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover modern-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-2"></i>ID</th>
                        <th><i class="fas fa-tag me-2"></i>Brinco</th>
                        <th><i class="fas fa-tags me-2"></i>Categoria</th>
                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                        <th><i class="fas fa-calendar me-2"></i>Cadastrado</th>
                        <th><i class="fas fa-weight me-2"></i>Último Peso</th>
                        <th><i class="fas fa-pills me-2"></i>Medicações</th>
                        <th><i class="fas fa-seedling me-2"></i>Alimentações</th>
                        <th><i class="fas fa-dollar-sign me-2"></i>Valor Investido</th>
                        <th><i class="fas fa-chart-line me-2"></i>Valor Vendido</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($animals as $animal)
                    <tr>
                        <td class="fw-bold">#{{ $animal->id }}</td>
                        <td>
                            <span class="text-dark fw-bold">{{ $animal->tag ?: 'Sem brinco' }}</span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $animal->category->name ?? 'Sem categoria' }}</span>
                        </td>
                        <td>
                            @if($animal->sale)
                                <span class="text-info fw-bold">Vendido</span>
                            @else
                                <span class="text-success fw-bold">Ativo</span>
                            @endif
                        </td>
                        <td>{{ $animal->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($animal->weights->count() > 0)
                                {{ number_format($animal->weights->last()->weight, 1) }}kg
                                @if($animal->weights->last()->recorded_at)
                                    <small class="text-muted">({{ $animal->weights->last()->recorded_at->format('d/m/Y') }})</small>
                                @endif
                            @else
                                <span class="text-muted">Sem pesagem</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-dark fw-bold">{{ $animal->medications->count() }}</span>
                        </td>
                        <td>
                            <span class="text-dark fw-bold">{{ $animal->feedings->count() }}</span>
                        </td>
                        <td>
                            @if($animal->purchase)
                                <span class="text-success fw-bold">R$ {{ number_format($animal->purchase->value, 2, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($animal->sale)
                                <span class="text-primary fw-bold">R$ {{ number_format($animal->sale->value, 2, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <br>Nenhum animal encontrado com os filtros aplicados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($animals->hasPages())
        <div class="card-footer">
            {{ $animals->withQueryString()->links() }}
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

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
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