@extends('layouts.app')

@section('title', 'Despesas Operacionais')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-calculator me-2"></i>Gerenciar Despesas Operacionais</h2>
            <a href="{{ route('operational-expenses.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Nova Despesa
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
        <form method="GET" action="{{ route('operational-expenses.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por despesa ou local..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="local_id" class="form-select modern-search-input">
                        <option value="">Todos os locais</option>
                        @foreach($locals as $local)
                            <option value="{{ $local->id }}" {{ request('local_id') == $local->id ? 'selected' : '' }}>
                                {{ $local->name }}
                            </option>
                        @endforeach
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
                    <a href="{{ route('operational-expenses.index') }}" class="modern-btn modern-btn-secondary w-100 mt-1" title="Limpar filtros">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($expenses->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Local</th>
                            <th>Tipo de Despesa</th>
                            <th>Data</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Valor</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr>
                                <td data-label="ID">{{ $expense->id }}</td>
                                <td data-label="Local">
                                    @if($expense->local)
                                        <strong class="text-primary">{{ $expense->local->name }}</strong>
                                        @php
                                            $localIsActive = !$expense->local->exit_date || \Carbon\Carbon::parse($expense->local->exit_date)->isFuture();
                                        @endphp
                                        @if($localIsActive)
                                            <br><small class="text-success">Ativo</small>
                                        @else
                                            <br><small class="text-muted">Inativo</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Despesa">
                                    <strong class="text-dark">{{ $expense->name }}</strong>
                                </td>
                                <td data-label="Data">
                                    {{ $expense->date ? \Carbon\Carbon::parse($expense->date)->format('d/m/Y') : 'N/A' }}
                                    <br><small class="text-muted">
                                        {{ $expense->date ? \Carbon\Carbon::parse($expense->date)->diffForHumans() : '' }}
                                    </small>
                                </td>
                                <td data-label="Quantidade">
                                    @if($expense->quantity)
                                        <strong class="text-info">
                                            {{ is_numeric($expense->quantity) ? number_format($expense->quantity, 3, ',', '.') : $expense->quantity }}
                                        </strong>
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
                                    <strong class="text-danger fs-5">
                                        R$ {{ number_format($expense->value, 2, ',', '.') }}
                                    </strong>
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('operational-expenses.edit', $expense) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('operational-expenses.destroy', $expense) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta despesa operacional?')">
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
                                    <h5 class="text-muted mb-1">Total de Despesas</h5>
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
                                    <h5 class="text-muted mb-1">Valor Médio</h5>
                                    <h3 class="text-warning">R$ {{ $expenses->count() > 0 ? number_format($expenses->avg('value'), 2, ',', '.') : '0,00' }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Este Mês</h5>
                                    <h3 class="text-info">{{ $expenses->filter(fn($e) => \Carbon\Carbon::parse($e->date)->isCurrentMonth())->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Expenses Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Despesas Mais Recentes</h5>
                        
                        @if($expenses->count() > 0)
                            <div class="row">
                                @foreach($expenses->take(4) as $recent)
                                    <div class="col-md-3 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="text-primary">{{ $recent->local->name ?? 'N/A' }}</h6>
                                                <h5 class="text-success mb-1">{{ $recent->name }}</h5>
                                                <h4 class="text-danger mb-1">R$ {{ number_format($recent->value, 2, ',', '.') }}</h4>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($recent->date)->format('d/m/Y') }}</small>
                                                <br><small class="text-info">{{ \Carbon\Carbon::parse($recent->date)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhuma despesa encontrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-calculator"></i>
                <h4>Nenhuma despesa encontrada</h4>
                <p class="mb-4">Não há despesas operacionais registradas no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('operational-expenses.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeira Despesa
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
