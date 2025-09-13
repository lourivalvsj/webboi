@extends('layouts.app')

@section('title', 'Compras')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-shopping-cart me-2"></i>Gerenciar Compras</h2>
            <a href="{{ route('purchases.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Nova Compra
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
        <form method="GET" action="{{ route('purchases.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por animal ou vendedor..." 
                               value="{{ request('search') }}">
                    </div>
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
                <div class="col-md-2">
                    <input type="number" name="min_value" class="form-control modern-search-input" 
                           placeholder="Valor mínimo" step="0.01"
                           value="{{ request('min_value') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_value" class="form-control modern-search-input" 
                           placeholder="Valor máximo" step="0.01"
                           value="{{ request('max_value') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($purchases->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal</th>
                            <th>Vendedor</th>
                            <th>Data Compra</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td data-label="ID">{{ $purchase->id }}</td>
                                <td data-label="Animal">
                                    @if($purchase->animal)
                                        <strong class="text-primary">{{ $purchase->animal->tag }}</strong>
                                        <br><small class="text-muted">{{ $purchase->animal->breed ?? '' }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Vendedor">
                                    @if($purchase->vendor)
                                        <strong>{{ $purchase->vendor->name }}</strong>
                                        @if($purchase->vendor->phone)
                                            <br><small class="text-muted">{{ $purchase->vendor->phone }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Data Compra">
                                    {{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td data-label="Valor">
                                    <strong class="text-success">
                                        R$ {{ number_format($purchase->value, 2, ',', '.') }}
                                    </strong>
                                </td>
                                <td data-label="Status">
                                    <span class="status-badge active">Finalizada</span>
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('purchases.show', $purchase) }}" 
                                           class="modern-btn modern-btn-info"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('purchases.edit', $purchase) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('purchases.destroy', $purchase) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta compra?')">
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

            {{-- Summary Card --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Total de Compras</h5>
                                    <h3 class="text-primary">{{ $purchases->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Valor Total</h5>
                                    <h3 class="text-success">R$ {{ number_format($purchases->sum('value'), 2, ',', '.') }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Valor Médio</h5>
                                    <h3 class="text-info">R$ {{ $purchases->count() > 0 ? number_format($purchases->avg('value'), 2, ',', '.') : '0,00' }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Este Mês</h5>
                                    <h3 class="text-warning">{{ $purchases->filter(fn($p) => \Carbon\Carbon::parse($p->purchase_date)->isCurrentMonth())->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-shopping-cart"></i>
                <h4>Nenhuma compra encontrada</h4>
                <p class="mb-4">Não há compras registradas no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('purchases.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeira Compra
                </a>
            </div>
        @endif
    </div>

    @if($purchases->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $purchases->firstItem() }} a {{ $purchases->lastItem() }} 
                    de {{ $purchases->total() }} resultados
                </div>
                {{ $purchases->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
