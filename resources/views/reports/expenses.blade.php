@extends('layouts.app')

@section('title', 'Relatório de Despesas')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-2">📊 Relatório de Despesas</h1>
            <p class="text-muted mb-0">Análise completa de todas as despesas por categoria</p>
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
            <form method="GET" action="{{ route('reports.expenses') }}" class="row g-3">
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
                        <i class="fas fa-chart-pie me-2"></i>Gerar Relatório
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumo por Categoria -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card expense-card supply-card text-white">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($expenses_by_category['supply']['medicamento'] + $expenses_by_category['supply']['alimentacao'], 2, ',', '.') }}</h4>
                    <small>Suprimentos</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card expense-card operational-card text-white">
                <div class="card-body text-center">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($expenses_by_category['operational'], 2, ',', '.') }}</h4>
                    <small>Operacionais</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card expense-card freight-card text-white">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($expenses_by_category['freight'], 2, ',', '.') }}</h4>
                    <small>Fretes</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card expense-card total-card text-white">
                <div class="card-body text-center">
                    <i class="fas fa-calculator fa-2x mb-2"></i>
                    <h4>R$ {{ number_format($total_expenses, 2, ',', '.') }}</h4>
                    <small>Total Geral</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Breakdown Detalhado -->
    <div class="row mb-4">
        <!-- Suprimentos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-box me-2"></i>Suprimentos</h5>
                </div>
                <div class="card-body">
                    <div class="expense-item mb-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-pills me-2 text-danger"></i>Medicamentos</span>
                            <span class="fw-bold">R$ {{ number_format($expenses_by_category['supply']['medicamento'], 2, ',', '.') }}</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-danger" 
                                 style="width: {{ $total_expenses > 0 ? ($expenses_by_category['supply']['medicamento'] / $total_expenses) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="expense-item">
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-seedling me-2 text-success"></i>Alimentação</span>
                            <span class="fw-bold">R$ {{ number_format($expenses_by_category['supply']['alimentacao'], 2, ',', '.') }}</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $total_expenses > 0 ? ($expenses_by_category['supply']['alimentacao'] / $total_expenses) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimos Suprimentos -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Últimos Gastos com Suprimentos</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Item</th>
                                <th>Categoria</th>
                                <th>Animal</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supply_expenses->take(8) as $expense)
                            <tr>
                                <td>{{ $expense->purchase_date->format('d/m/Y') }}</td>
                                <td>{{ $expense->name }}</td>
                                <td>
                                    <span class="badge {{ $expense->category == 'medicamento' ? 'bg-danger' : 'bg-success' }}">
                                        {{ $expense->category_label }}
                                    </span>
                                </td>
                                <td>#{{ $expense->animal->id ?? 'N/A' }}</td>
                                <td class="text-end fw-bold">R$ {{ number_format($expense->value, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Nenhum gasto com suprimentos no período
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Despesas Operacionais e Fretes -->
    <div class="row">
        <!-- Despesas Operacionais -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0"><i class="fas fa-cogs me-2"></i>Despesas Operacionais</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Local</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($operational_expenses->take(8) as $expense)
                            <tr>
                                <td>{{ $expense->date->format('d/m/Y') }}</td>
                                <td>{{ $expense->name }}</td>
                                <td>{{ $expense->local->name ?? 'N/A' }}</td>
                                <td class="text-end fw-bold">R$ {{ number_format($expense->value, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Nenhuma despesa operacional no período
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Fretes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-truck me-2"></i>Gastos com Fretes</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Caminhoneiro</th>
                                <th>Qtd.</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($freight_expenses->take(8) as $freight)
                            <tr>
                                <td>{{ $freight->departure_date ? $freight->departure_date->format('d/m/Y') : '-' }}</td>
                                <td>{{ $freight->truckDriver->name ?? 'N/A' }}</td>
                                <td>{{ $freight->quantity_animals }} animais</td>
                                <td class="text-end fw-bold">R$ {{ number_format($freight->value, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Nenhum gasto com frete no período
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.expense-card {
    border-radius: 12px;
    border: none;
    transition: transform 0.3s ease;
}

.expense-card:hover {
    transform: translateY(-5px);
}

.supply-card {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
}

.operational-card {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.freight-card {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}

.total-card {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
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