@extends('layouts.app')

@section('title', 'Gastos com Insumos')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-boxes me-2"></i>Gerenciar Gastos com Insumos</h2>
            <a href="{{ route('supply-expenses.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Novo Gasto
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-search-container">
        <form method="GET" action="{{ route('supply-expenses.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por produto ou descrição..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-select modern-search-input">
                        <option value="">Todas as categorias</option>
                        <option value="medicamento" {{ request('category') == 'medicamento' ? 'selected' : '' }}>
                            Medicamento
                        </option>
                        <option value="alimentacao" {{ request('category') == 'alimentacao' ? 'selected' : '' }}>
                            Alimentação
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control modern-search-input" 
                           placeholder="Data inicial" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control modern-search-input" 
                           placeholder="Data final" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <input type="number" name="min_value" class="form-control modern-search-input" 
                           placeholder="Valor mín" step="0.01"
                           value="{{ request('min_value') }}">
                </div>
                <div class="col-md-1">
                    <input type="number" name="max_value" class="form-control modern-search-input" 
                           placeholder="Valor máx" step="0.01"
                           value="{{ request('max_value') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('supply-expenses.index') }}" class="modern-btn modern-btn-secondary w-100 mt-1" title="Limpar filtros">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($expenses->count() > 0)
            <!-- Legenda de Status de Estoque -->
            <div class="alert alert-info mb-3">
                <h6 class="mb-2"><i class="fas fa-info-circle"></i> Legenda de Status de Estoque:</h6>
                <div class="row">
                    <div class="col-md-4">
                        <span class="badge bg-success me-2">Normal</span> Estoque adequado
                    </div>
                    <div class="col-md-4">
                        <span class="badge bg-warning me-2">Baixo</span> Menos de 10% restante
                    </div>
                    <div class="col-md-4">
                        <span class="badge bg-danger me-2">Esgotado</span> Sem estoque
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto/Insumo</th>
                            <th>Categoria</th>
                            <th>Data de Compra</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Valor</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr class="{{ $expense->remaining_quantity <= 0 ? 'table-danger' : ($expense->is_low_stock ? 'table-warning' : '') }}">
                                <td data-label="ID">{{ $expense->id }}</td>
                                <td data-label="Produto">
                                    <strong class="text-primary">{{ $expense->name }}</strong>
                                    @if($expense->description)
                                        <br><small class="text-muted">{{ Str::limit($expense->description, 120) }}</small>
                                    @endif
                                </td>
                                <td data-label="Categoria">
                                    <strong class="text-dark">{{ $expense->category_label }}</strong>
                                </td>
                                <td data-label="Data">
                                    {{ $expense->purchase_date ? \Carbon\Carbon::parse($expense->purchase_date)->format('d/m/Y') : 'N/A' }}
                                    <br><small class="text-muted">
                                        {{ $expense->purchase_date ? \Carbon\Carbon::parse($expense->purchase_date)->diffForHumans() : '' }}
                                    </small>
                                </td>
                                <td data-label="Quantidade">
                                    @if($expense->quantity)
                                        <!-- Debug: Valor raw = {{ $expense->getRawOriginal('quantity') ?? 'NULL' }}, Valor formatado = {{ $expense->quantity }} -->
                                        <strong class="text-info">
                                            {{ is_numeric($expense->quantity) ? number_format($expense->quantity, 3, ',', '.') : $expense->quantity }}
                                        </strong>
                                        <br>
                                        <small class="d-block mt-1">
                                            @php
                                                $remaining = $expense->remaining_quantity;
                                            @endphp
                                            @if($expense->is_low_stock)
                                                <span class="text-danger fw-bold">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Restam: {{ number_format($remaining, 3, ',', '.') }}
                                                </span>
                                            @elseif($remaining <= 0)
                                                <span class="text-danger fw-bold">
                                                    <i class="fas fa-times-circle"></i>
                                                    Esgotado
                                                </span>
                                            @else
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle"></i>
                                                    Restam: {{ number_format($remaining, 3, ',', '.') }}
                                                </span>
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Unidade">
                                    @if($expense->unit_of_measure)
                                        <span class="text-dark">{{ $expense->unit_of_measure }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Valor">
                                    <!-- Debug: Valor raw = {{ $expense->getRawOriginal('value') ?? 'NULL' }}, Valor formatado = {{ $expense->value }} -->
                                    <strong class="text-danger fs-5">
                                        R$ {{ number_format($expense->value, 2, ',', '.') }}
                                    </strong>
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('supply-expenses.edit', $expense) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('supply-expenses.destroy', $expense) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este gasto com insumo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="modern-btn modern-btn-danger"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Total de Gastos</h5>
                                    <h3 class="text-primary">{{ $expenses->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Valor Total</h5>
                                    <h3 class="text-danger">R$ {{ number_format($expenses->sum('value'), 2, ',', '.') }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Medicamentos</h5>
                                    <h3 class="text-warning">{{ $expenses->filter(fn($e) => $e->category == 'medicamento')->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Alimentação</h5>
                                    <h3 class="text-success">{{ $expenses->filter(fn($e) => $e->category == 'alimentacao')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Category Analysis Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Análise por Categoria</h5>
                        
                        <div class="row">
                            @php
                                $medicamentoTotal = $expenses->filter(fn($e) => $e->category == 'medicamento')->sum('value');
                                $alimentacaoTotal = $expenses->filter(fn($e) => $e->category == 'alimentacao')->sum('value');
                            @endphp
                            
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-pills text-danger me-2 fs-4"></i>
                                            <h5 class="mb-0">Medicamentos</h5>
                                        </div>
                                        <h3 class="text-danger mb-1">R$ {{ number_format($medicamentoTotal, 2, ',', '.') }}</h3>
                                        <small class="text-muted">{{ $expenses->filter(fn($e) => $e->category == 'medicamento')->count() }} itens</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-utensils text-success me-2 fs-4"></i>
                                            <h5 class="mb-0">Alimentação</h5>
                                        </div>
                                        <h3 class="text-success mb-1">R$ {{ number_format($alimentacaoTotal, 2, ',', '.') }}</h3>
                                        <small class="text-muted">{{ $expenses->filter(fn($e) => $e->category == 'alimentacao')->count() }} itens</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-boxes"></i>
                <h4>Nenhum gasto encontrado</h4>
                <p class="mb-4">Não há gastos com insumos registrados no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('supply-expenses.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeiro Gasto
                </a>
            </div>
        @endif
    </div>

    @if($expenses->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $expenses->firstItem() }} a {{ $expenses->lastItem() }} 
                    de {{ $expenses->total() }} resultados
                </div>
                {{ $expenses->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
