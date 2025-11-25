@extends('layouts.app')

@section('title', 'Fretes')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-truck me-2"></i>Gerenciar Fretes</h2>
            <a href="{{ route('freights.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Novo Frete
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
        <form method="GET" action="{{ route('freights.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por caminhoneiro ou local..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="truck_driver_id" class="form-select modern-search-input">
                        <option value="">Todos os caminhoneiros</option>
                        @foreach($truckDrivers as $driver)
                            <option value="{{ $driver->id }}" {{ request('truck_driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
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
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('freights.index') }}" class="modern-btn modern-btn-secondary w-100 mt-1" title="Limpar filtros">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($freights->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Caminhoneiro</th>
                            <th>Local de Destino</th>
                            <th>Qtd. Animais</th>
                            <th>Valor do Frete</th>
                            <th>Data de Saída</th>
                            <th>Data de Chegada</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($freights as $freight)
                            @php
                                $now = now();
                                $departureDate = $freight->departure_date ? \Carbon\Carbon::parse($freight->departure_date) : null;
                                $arrivalDate = $freight->arrival_date ? \Carbon\Carbon::parse($freight->arrival_date) : null;
                                
                                $status = 'Agendado';
                                $statusClass = 'bg-warning';
                                
                                if ($departureDate && $departureDate->isPast()) {
                                    if ($arrivalDate && $arrivalDate->isPast()) {
                                        $status = 'Finalizado';
                                        $statusClass = 'bg-success';
                                    } else {
                                        $status = 'Em Trânsito';
                                        $statusClass = 'bg-info';
                                    }
                                }
                                
                                $duration = null;
                                if ($departureDate && $arrivalDate) {
                                    $duration = $departureDate->diffInDays($arrivalDate);
                                }
                            @endphp
                            <tr>
                                <td data-label="ID">{{ $freight->id }}</td>
                                <td data-label="Caminhoneiro">
                                    @if($freight->truckDriver)
                                        <strong class="text-primary">{{ $freight->truckDriver->name }}</strong>
                                        @if($freight->truckDriver->phone)
                                            <br><small class="text-muted">{{ $freight->truckDriver->phone }}</small>
                                        @endif
                                        @if($freight->truckDriver->license_plate)
                                            <br><small class="text-info">{{ $freight->truckDriver->license_plate }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Local">
                                    @if($freight->local)
                                        <strong class="text-dark">{{ $freight->local->name }}</strong>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Animais">
                                    <strong class="text-success fs-5">
                                        {{ $freight->quantity_animals }}
                                        @if($freight->quantity_animals == 1)
                                            animal
                                        @else
                                            animais
                                        @endif
                                    </strong>
                                </td>
                                <td data-label="Valor">
                                    <strong class="text-danger fs-5">
                                        R$ {{ number_format($freight->value, 2, ',', '.') }}
                                    </strong>
                                    @if($freight->quantity_animals > 0)
                                        <br><small class="text-muted">
                                            R$ {{ number_format($freight->value / $freight->quantity_animals, 2, ',', '.') }}/animal
                                        </small>
                                    @endif
                                </td>
                                <td data-label="Saída">
                                    @if($freight->departure_date)
                                        {{ \Carbon\Carbon::parse($freight->departure_date)->format('d/m/Y') }}
                                        <br><small class="text-muted">
                                            {{ \Carbon\Carbon::parse($freight->departure_date)->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Chegada">
                                    @if($freight->arrival_date)
                                        {{ \Carbon\Carbon::parse($freight->arrival_date)->format('d/m/Y') }}
                                        <br><small class="text-muted">
                                            {{ \Carbon\Carbon::parse($freight->arrival_date)->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    <span class="badge {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                    @if($duration !== null)
                                        <br><small class="text-muted">{{ $duration }} dia(s)</small>
                                    @endif
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('freights.edit', $freight) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('freights.destroy', $freight) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este frete?')">
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
                                    <h5 class="text-muted mb-1">Total de Fretes</h5>
                                    <h3 class="text-primary">{{ $freights->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Valor Total</h5>
                                    <h3 class="text-danger">R$ {{ number_format($freights->sum('value'), 2, ',', '.') }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Animais Transportados</h5>
                                    <h3 class="text-success">{{ $freights->sum('quantity_animals') }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Valor Médio</h5>
                                    <h3 class="text-warning">R$ {{ $freights->count() > 0 ? number_format($freights->avg('value'), 2, ',', '.') : '0,00' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Analysis Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-chart-line me-2"></i>Análise de Status</h5>
                        
                        <div class="row">
                            @php
                                $now = now();
                                $agendados = $freights->filter(function($f) use ($now) {
                                    $dep = $f->departure_date ? \Carbon\Carbon::parse($f->departure_date) : null;
                                    return $dep && $dep->isFuture();
                                })->count();
                                
                                $emTransito = $freights->filter(function($f) use ($now) {
                                    $dep = $f->departure_date ? \Carbon\Carbon::parse($f->departure_date) : null;
                                    $arr = $f->arrival_date ? \Carbon\Carbon::parse($f->arrival_date) : null;
                                    return $dep && $dep->isPast() && $arr && $arr->isFuture();
                                })->count();
                                
                                $finalizados = $freights->filter(function($f) use ($now) {
                                    $arr = $f->arrival_date ? \Carbon\Carbon::parse($f->arrival_date) : null;
                                    return $arr && $arr->isPast();
                                })->count();
                            @endphp
                            
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-clock text-warning me-2 fs-4"></i>
                                            <h5 class="mb-0">Agendados</h5>
                                        </div>
                                        <h3 class="text-warning mb-1">{{ $agendados }}</h3>
                                        <small class="text-muted">fretes futuros</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-shipping-fast text-info me-2 fs-4"></i>
                                            <h5 class="mb-0">Em Trânsito</h5>
                                        </div>
                                        <h3 class="text-info mb-1">{{ $emTransito }}</h3>
                                        <small class="text-muted">fretes em andamento</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2 fs-4"></i>
                                            <h5 class="mb-0">Finalizados</h5>
                                        </div>
                                        <h3 class="text-success mb-1">{{ $finalizados }}</h3>
                                        <small class="text-muted">fretes concluídos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-truck"></i>
                <h4>Nenhum frete encontrado</h4>
                <p class="mb-4">Não há fretes registrados no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('freights.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Registrar Primeiro Frete
                </a>
            </div>
        @endif
    </div>

    @if($freights->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $freights->firstItem() }} a {{ $freights->lastItem() }} 
                    de {{ $freights->total() }} resultados
                </div>
                {{ $freights->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
