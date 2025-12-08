@extends('layouts.app')

@section('title', 'Pesagens')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-weight me-2"></i>Gerenciar Pesagens</h2>
            <div>
                <a href="{{ route('animal-weights.create-bulk') }}" class="modern-btn modern-btn-primary me-2">
                    <i class="fas fa-plus-circle"></i>
                    Múltiplas Pesagens
                </a>
                <a href="{{ route('animal-weights.create') }}" class="modern-btn modern-btn-success">
                    <i class="fas fa-plus"></i>
                    Nova Pesagem
                </a>
            </div>
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

    <!-- Filtros de Pesquisa -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros de Pesquisa</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('animal-weights.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-cow me-1"></i>Animal</label>
                    <select name="animal_id" class="form-select">
                        <option value="">Todos os Animais</option>
                        @foreach($animals as $animal)
                            <option value="{{ $animal->id }}" {{ request('animal_id') == $animal->id ? 'selected' : '' }}>
                                {{ $animal->tag }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-weight me-1"></i>Peso Mín. (kg)</label>
                    <input type="number" name="weight_min" class="form-control" step="0.01" 
                           value="{{ request('weight_min') }}" placeholder="Ex: 50.00">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-weight me-1"></i>Peso Máx. (kg)</label>
                    <input type="number" name="weight_max" class="form-control" step="0.01" 
                           value="{{ request('weight_max') }}" placeholder="Ex: 200.00">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-calendar me-1"></i>Data De</label>
                    <input type="date" name="date_from" class="form-control" 
                           value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-calendar me-1"></i>Data Até</label>
                    <input type="date" name="date_to" class="form-control" 
                           value="{{ request('date_to') }}">
                </div>
                
                <div class="col-md-1 d-flex align-items-end">
                    <div class="btn-group w-100" role="group">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('animal-weights.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Informações dos Resultados -->
    @if(request()->hasAny(['animal_id', 'weight_min', 'weight_max', 'date_from', 'date_to']))
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Filtros Ativos:</strong>
            @if(request('animal_id'))
                Animal: <strong>{{ $animals->firstWhere('id', request('animal_id'))->tag ?? 'N/A' }}</strong>
            @endif
            @if(request('weight_min'))
                | Peso mín: <strong>{{ request('weight_min') }}kg</strong>
            @endif
            @if(request('weight_max'))
                | Peso máx: <strong>{{ request('weight_max') }}kg</strong>
            @endif
            @if(request('date_from'))
                | De: <strong>{{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}</strong>
            @endif
            @if(request('date_to'))
                | Até: <strong>{{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}</strong>
            @endif
            <br>
            <small>{{ $weights->total() }} pesagem(ns) encontrada(s)</small>
        </div>
    @endif

    <div class="modern-table-container">
        @if($weights->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Animal</th>
                            <th>Peso (kg)</th>
                            <th>Data de Pesagem</th>
                            <th>Observações</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weights as $weight)
                            <tr>
                                <td data-label="ID">{{ $weight->id }}</td>
                                <td data-label="Animal">
                                    @if($weight->animal)
                                        <strong class="text-primary">{{ $weight->animal->tag }}</strong>
                                        @if($weight->animal->breed)
                                            <br><small class="text-info">{{ $weight->animal->breed }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Peso">
                                    <strong class="text-success fs-5">
                                        {{ number_format($weight->weight, 2, ',', '.') }} kg
                                    </strong>
                                </td>
                                <td data-label="Data">
                                    {{ $weight->recorded_at ? \Carbon\Carbon::parse($weight->recorded_at)->format('d/m/Y') : 'N/A' }}
                                    <br><small class="text-muted">
                                        {{ $weight->recorded_at ? \Carbon\Carbon::parse($weight->recorded_at)->diffForHumans() : '' }}
                                    </small>
                                </td>
                                <td data-label="Observações">
                                    @php
                                        $daysSinceLastWeight = null;
                                        $weightGain = null;
                                        
                                        if($weight->animal) {
                                            $previousWeight = $weight->animal->animalWeights()
                                                ->where('recorded_at', '<', $weight->recorded_at)
                                                ->orderBy('recorded_at', 'desc')
                                                ->first();
                                            
                                            if($previousWeight) {
                                                $daysSinceLastWeight = \Carbon\Carbon::parse($previousWeight->recorded_at)
                                                    ->diffInDays(\Carbon\Carbon::parse($weight->recorded_at));
                                                $weightGain = $weight->weight - $previousWeight->weight;
                                            }
                                        }
                                    @endphp
                                    
                                    @if($weightGain !== null)
                                        <span class="badge {{ $weightGain >= 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $weightGain >= 0 ? '+' : '' }}{{ number_format($weightGain, 2, ',', '.') }} kg
                                        </span>
                                        @if($daysSinceLastWeight)
                                            <br><small class="text-muted">{{ $daysSinceLastWeight }} dias</small>
                                        @endif
                                    @else
                                        <small class="text-muted">Primeira pesagem</small>
                                    @endif
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('animal-weights.edit', $weight) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('animal-weights.destroy', $weight) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta pesagem?')">
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
                                    <h5 class="text-muted mb-1">Total de Pesagens</h5>
                                    <h3 class="text-primary">{{ $weights->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Nesta Página</h5>
                                    <h3 class="text-success">{{ $weights->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Maior Peso</h5>
                                    <h3 class="text-warning">{{ $weights->count() > 0 ? number_format($weights->max('weight'), 2, ',', '.') : '0,00' }} kg</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Menor Peso</h5>
                                    <h3 class="text-info">{{ $weights->count() > 0 ? number_format($weights->min('weight'), 2, ',', '.') : '0,00' }} kg</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-chart-line me-2"></i>Pesagens Mais Recentes</h5>
                        
                        @if($weights->count() > 0)
                            <div class="row">
                                @foreach($weights->take(4) as $recent)
                                    <div class="col-md-3 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="text-primary">{{ $recent->animal->tag ?? 'N/A' }}</h6>
                                                <h4 class="text-success mb-1">{{ number_format($recent->weight, 1, ',', '.') }} kg</h4>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($recent->recorded_at)->format('d/m/Y') }}</small>
                                                <br><small class="text-info">{{ \Carbon\Carbon::parse($recent->recorded_at)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhuma pesagem encontrada.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-weight"></i>
                <h4>Nenhuma pesagem encontrada</h4>
                <p class="mb-4">Não há pesagens registradas no sistema. Comece registrando a primeira pesagem dos seus animais.</p>
                <a href="{{ route('animal-weights.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeira Pesagem
                </a>
            </div>
        @endif
    </div>

    @if($weights->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $weights->firstItem() }} a {{ $weights->lastItem() }} 
                    de {{ $weights->total() }} resultados
                </div>
                {{ $weights->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
