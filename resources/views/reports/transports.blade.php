@extends('layouts.app')

@section('title', 'Relatório de Transportes')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-2">🚛 Relatório de Transportes</h1>
            <p class="text-muted mb-0">Análise detalhada dos fretes e transportes</p>
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
            <form method="GET" action="{{ route('reports.transports') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Caminhoneiro</label>
                    <select name="truck_driver_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach(\App\Models\TruckDriver::all() as $driver)
                            <option value="{{ $driver->id }}" {{ request('truck_driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Local</label>
                    <select name="local_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach(\App\Models\Local::all() as $local)
                            <option value="{{ $local->id }}" {{ request('local_id') == $local->id ? 'selected' : '' }}>
                                {{ $local->name }}
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
                    <i class="fas fa-truck fa-2x mb-2"></i>
                    <h4>{{ $stats['total_transports'] }}</h4>
                    <small>Total de Fretes</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['total_freight_cost'], 2, ',', '.') }}</h4>
                    <small>Custo Total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-cow fa-2x mb-2"></i>
                    <h4>{{ $stats['total_animals_transported'] }}</h4>
                    <small>Animais Transportados</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($stats['average_cost_per_transport'], 2, ',', '.') }}</h4>
                    <small>Custo Médio/Frete</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 mb-3">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-balance-scale fa-2x mb-2"></i>
                    <h4>{{ number_format($stats['average_animals_per_transport'], 1) }}</h4>
                    <small>Animais/Frete</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Transportes -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Transportes Realizados - {{ $transports->total() }} registros</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover modern-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar me-2"></i>Partida</th>
                        <th><i class="fas fa-calendar-check me-2"></i>Chegada</th>
                        <th><i class="fas fa-user me-2"></i>Caminhoneiro</th>
                        <th><i class="fas fa-map-marker-alt me-2"></i>Destino</th>
                        <th><i class="fas fa-cow me-2"></i>Qtd. Animais</th>
                        <th><i class="fas fa-dollar-sign me-2"></i>Valor Frete</th>
                        <th><i class="fas fa-calculator me-2"></i>Custo/Animal</th>
                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transports as $transport)
                    @php
                        $costPerAnimal = $transport->quantity_animals > 0 ? $transport->value / $transport->quantity_animals : 0;
                        $status = 'Agendado';
                        $badgeClass = 'bg-warning';
                        
                        if ($transport->departure_date && $transport->departure_date->isPast()) {
                            if ($transport->arrival_date && $transport->arrival_date->isPast()) {
                                $status = 'Concluído';
                                $badgeClass = 'bg-success';
                            } else {
                                $status = 'Em Trânsito';
                                $badgeClass = 'bg-primary';
                            }
                        }
                    @endphp
                    <tr>
                        <td>{{ $transport->departure_date ? $transport->departure_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $transport->arrival_date ? $transport->arrival_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $transport->truckDriver->name ?? 'N/A' }}</td>
                        <td>{{ $transport->local->name ?? 'N/A' }}</td>
                        <td class="text-center fw-bold">{{ $transport->quantity_animals }}</td>
                        <td class="fw-bold text-danger">R$ {{ number_format($transport->value, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($costPerAnimal, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <br>Nenhum transporte encontrado com os filtros aplicados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transports->hasPages())
        <div class="card-footer">
            {{ $transports->withQueryString()->links() }}
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