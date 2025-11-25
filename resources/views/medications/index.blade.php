@extends('layouts.app')

@section('title', 'Medicações')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-pills me-2"></i>Gerenciar Medicações</h2>
            <a href="{{ route('medications.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Nova Medicação
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
        <form method="GET" action="{{ route('medications.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por animal ou medicamento..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="medication_name" class="form-select modern-search-input">
                        <option value="">Todos os medicamentos</option>
                        @foreach($medicationNames as $name)
                            <option value="{{ $name }}" {{ request('medication_name') == $name ? 'selected' : '' }}>
                                {{ $name }}
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
                    <a href="{{ route('medications.index') }}" class="modern-btn modern-btn-secondary w-100" title="Limpar filtros">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($medications->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal</th>
                            <th>Medicamento</th>
                            <th>Dosagem</th>
                            <th>Unidade</th>
                            <th>Data de Administração</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medications as $medication)
                            <tr>
                                <td data-label="ID">{{ $medication->id }}</td>
                                <td data-label="Animal">
                                    @if($medication->animal)
                                        <strong class="text-primary">{{ $medication->animal->tag }}</strong>
                                        @if($medication->animal->name)
                                            <br><small class="text-muted">{{ $medication->animal->name }}</small>
                                        @endif
                                        @if($medication->animal->breed)
                                            <br><small class="text-info">{{ $medication->animal->breed }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Medicamento">
                                    <strong class="text-dark">{{ $medication->medication_name }}</strong>
                                </td>
                                <td data-label="Dosagem">
                                    <strong class="text-success fs-5">
                                        {{ is_numeric($medication->dose) ? number_format($medication->dose, 3, ',', '.') : $medication->dose }}
                                    </strong>
                                </td>
                                <td data-label="Unidade">
                                    @if($medication->unit_of_measure)
                                        <span class="text-dark">{{ $medication->unit_of_measure }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Data">
                                    {{ $medication->administration_date ? \Carbon\Carbon::parse($medication->administration_date)->format('d/m/Y') : 'N/A' }}
                                    <br><small class="text-muted">
                                        {{ $medication->administration_date ? \Carbon\Carbon::parse($medication->administration_date)->diffForHumans() : '' }}
                                    </small>
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('medications.edit', $medication) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('medications.destroy', $medication) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este registro de medicação?')">
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
                                    <h3 class="text-primary">{{ $medications->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Nesta Página</h5>
                                    <h3 class="text-success">{{ $medications->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Tipos de Medicamento</h5>
                                    <h3 class="text-warning">{{ $medicationNames->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Este Mês</h5>
                                    <h3 class="text-info">{{ $medications->filter(fn($m) => \Carbon\Carbon::parse($m->administration_date)->isCurrentMonth())->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Medications Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Medicações Mais Recentes</h5>
                        
                        @if($medications->count() > 0)
                            <div class="row">
                                @foreach($medications->take(4) as $recent)
                                    <div class="col-md-3 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="text-primary">{{ $recent->animal->tag ?? 'N/A' }}</h6>
                                                <h5 class="text-success mb-1">{{ $recent->medication_name }}</h5>
                                                <p class="mb-1">{{ is_numeric($recent->dose) ? number_format($recent->dose, 2, ',', '.') : $recent->dose }} {{ $recent->unit_of_measure }}</p>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($recent->administration_date)->format('d/m/Y') }}</small>
                                                <br><small class="text-info">{{ \Carbon\Carbon::parse($recent->administration_date)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhuma medicação encontrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-pills"></i>
                <h4>Nenhuma medicação encontrada</h4>
                <p class="mb-4">Não há registros de medicação no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('medications.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeira Medicação
                </a>
            </div>
        @endif
    </div>

    @if($medications->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $medications->firstItem() }} a {{ $medications->lastItem() }} 
                    de {{ $medications->total() }} resultados
                </div>
                {{ $medications->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
