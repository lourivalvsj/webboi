@extends('layouts.app')

@section('title', 'Locais')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-map-marker-alt me-2"></i>Gerenciar Locais</h2>
            <a href="{{ route('locals.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Novo Local
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
        <form method="GET" action="{{ route('locals.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por nome do local..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select modern-search-input">
                        <option value="">Todos os status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Ativo
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Inativo
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
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('locals.index') }}" class="modern-btn modern-btn-secondary w-100" title="Limpar filtros">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($locals->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Local</th>
                            <th>Data de Entrada</th>
                            <th>Data de Saída</th>
                            <th>Status</th>
                            <th>Período</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locals as $local)
                            @php
                                $isActive = !$local->exit_date || \Carbon\Carbon::parse($local->exit_date)->isFuture();
                                $entryDate = $local->entry_date ? \Carbon\Carbon::parse($local->entry_date) : null;
                                $exitDate = $local->exit_date ? \Carbon\Carbon::parse($local->exit_date) : null;
                                $period = null;
                                
                                if ($entryDate && $exitDate) {
                                    $period = $entryDate->diffInDays($exitDate) . ' dias';
                                } elseif ($entryDate) {
                                    $period = $entryDate->diffInDays(now()) . ' dias (ativo)';
                                }
                            @endphp
                            <tr>
                                <td data-label="ID">{{ $local->id }}</td>
                                <td data-label="Nome">
                                    <strong class="text-primary">{{ $local->name }}</strong>
                                </td>
                                <td data-label="Entrada">
                                    @if($local->entry_date)
                                        {{ \Carbon\Carbon::parse($local->entry_date)->format('d/m/Y') }}
                                        <br><small class="text-muted">
                                            {{ \Carbon\Carbon::parse($local->entry_date)->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Saída">
                                    @if($local->exit_date)
                                        {{ \Carbon\Carbon::parse($local->exit_date)->format('d/m/Y') }}
                                        <br><small class="text-muted">
                                            {{ \Carbon\Carbon::parse($local->exit_date)->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    @if($isActive)
                                        <span class="status-badge active">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Ativo
                                        </span>
                                    @else
                                        <span class="status-badge inactive">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Inativo
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Período">
                                    @if($period)
                                        <strong class="text-info">{{ $period }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('locals.edit', $local) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('locals.destroy', $local) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este local?')">
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
                                    <h5 class="text-muted mb-1">Total de Locais</h5>
                                    <h3 class="text-primary">{{ $locals->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Locais Ativos</h5>
                                    <h3 class="text-success">
                                        {{ $locals->filter(function($l) { 
                                            return !$l->exit_date || \Carbon\Carbon::parse($l->exit_date)->isFuture(); 
                                        })->count() }}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Locais Inativos</h5>
                                    <h3 class="text-warning">
                                        {{ $locals->filter(function($l) { 
                                            return $l->exit_date && \Carbon\Carbon::parse($l->exit_date)->isPast(); 
                                        })->count() }}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Nesta Página</h5>
                                    <h3 class="text-info">{{ $locals->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Locals Cards --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Locais Mais Recentes</h5>
                        
                        @if($locals->count() > 0)
                            <div class="row">
                                @foreach($locals->take(4) as $recent)
                                    @php
                                        $recentIsActive = !$recent->exit_date || \Carbon\Carbon::parse($recent->exit_date)->isFuture();
                                    @endphp
                                    <div class="col-md-3 mb-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="text-primary">{{ $recent->name }}</h6>
                                                <div class="mb-2">
                                                    @if($recentIsActive)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inativo</span>
                                                    @endif
                                                </div>
                                                @if($recent->entry_date)
                                                    <small class="text-muted">Entrada: {{ \Carbon\Carbon::parse($recent->entry_date)->format('d/m/Y') }}</small>
                                                @endif
                                                @if($recent->exit_date)
                                                    <br><small class="text-muted">Saída: {{ \Carbon\Carbon::parse($recent->exit_date)->format('d/m/Y') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nenhum local encontrado.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Nenhum local encontrado</h4>
                <p class="mb-4">Não há locais cadastrados no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('locals.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Cadastrar Primeiro Local
                </a>
            </div>
        @endif
    </div>

    @if($locals->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $locals->firstItem() }} a {{ $locals->lastItem() }} 
                    de {{ $locals->total() }} resultados
                </div>
                {{ $locals->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
