@extends('layouts.app')

@section('title', 'Alimentações')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-utensils me-2"></i>Gerenciar Alimentações</h2>
            <a href="{{ route('feedings.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Nova Alimentação
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
        <form method="GET" action="{{ route('feedings.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por animal ou tipo de alimento..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="feed_type" class="form-select modern-search-input">
                        <option value="">Todos os alimentos</option>
                        @foreach($feedTypes as $type)
                            <option value="{{ $type }}" {{ request('feed_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
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
                <div class="col-md-2">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                        Filtrar
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('feedings.index') }}" class="modern-btn modern-btn-secondary w-100" title="Limpar filtros">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($feedings->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal</th>
                            <th>Tipo de Alimento</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Data de Alimentação</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedings as $feeding)
                            <tr>
                                <td data-label="ID">{{ $feeding->id }}</td>
                                <td data-label="Animal">
                                    @if($feeding->animal)
                                        <strong class="text-primary">{{ $feeding->animal->tag }}</strong>
                                        @if($feeding->animal->name)
                                            <br><small class="text-muted">{{ $feeding->animal->name }}</small>
                                        @endif
                                        @if($feeding->animal->breed)
                                            <br><small class="text-info">{{ $feeding->animal->breed }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Tipo de Alimento">
                                    <strong class="text-dark">{{ $feeding->feed_type }}</strong>
                                </td>
                                <td data-label="Quantidade">
                                    <strong class="text-success fs-5">
                                        {{ is_numeric($feeding->quantity) ? number_format($feeding->quantity, 3, ',', '.') : $feeding->quantity }}
                                    </strong>
                                </td>
                                <td data-label="Unidade">
                                    @if($feeding->unit_of_measure)
                                        <span class="text-dark">{{ $feeding->unit_of_measure }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Data">
                                    {{ $feeding->feeding_date ? \Carbon\Carbon::parse($feeding->feeding_date)->format('d/m/Y') : 'N/A' }}
                                    <br><small class="text-muted">
                                        {{ $feeding->feeding_date ? \Carbon\Carbon::parse($feeding->feeding_date)->diffForHumans() : '' }}
                                    </small>
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('feedings.edit', $feeding) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('feedings.destroy', $feeding) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este registro de alimentação?')">
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
                                    <h5 class="text-muted mb-1">Total de Registros</h5>
                                    <h3 class="text-primary">{{ $feedings->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Nesta Página</h5>
                                    <h3 class="text-success">{{ $feedings->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Tipos de Alimento</h5>
                                    <h3 class="text-warning">{{ $feedTypes->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Este Mês</h5>
                                    <h3 class="text-info">{{ $feedings->filter(fn($f) => \Carbon\Carbon::parse($f->feeding_date)->isCurrentMonth())->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Feedings Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Alimentações Mais Recentes</h5>
                        
                        @if($feedings->count() > 0)
                            <div class="row">
                                @foreach($feedings->take(4) as $recent)
                                    <div class="col-md-3 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="text-primary">{{ $recent->animal->tag ?? 'N/A' }}</h6>
                                                <h5 class="text-success mb-1">{{ $recent->feed_type }}</h5>
                                                <p class="mb-1">{{ is_numeric($recent->quantity) ? number_format($recent->quantity, 2, ',', '.') : $recent->quantity }} {{ $recent->unit_of_measure }}</p>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($recent->feeding_date)->format('d/m/Y') }}</small>
                                                <br><small class="text-info">{{ \Carbon\Carbon::parse($recent->feeding_date)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhuma alimentação encontrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-utensils"></i>
                <h4>Nenhuma alimentação encontrada</h4>
                <p class="mb-4">Não há registros de alimentação no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('feedings.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeira Alimentação
                </a>
            </div>
        @endif
    </div>

    @if($feedings->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $feedings->firstItem() }} a {{ $feedings->lastItem() }} 
                    de {{ $feedings->total() }} resultados
                </div>
                {{ $feedings->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
