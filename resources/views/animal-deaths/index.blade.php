@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-cross text-danger me-3" style="font-size: 2rem;"></i>
            <div>
                <h1 class="h3 mb-0 text-gray-800">Óbitos de Animais</h1>
                <p class="text-muted mb-0">Gerenciar registro de óbitos e causas de morte</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('animal-deaths.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-2"></i>Registrar Óbito
            </a>
            <a href="{{ route('animals.index') }}" class="btn btn-secondary">
                <i class="fas fa-paw me-2"></i>Animais Vivos
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="fas fa-filter me-2"></i>Filtros de Pesquisa
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('animal-deaths.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Pesquisar Animal</label>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Nome ou tag do animal">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Data Inicial</label>
                        <input type="date" class="form-control" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Data Final</label>
                        <input type="date" class="form-control" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Local da Morte</label>
                        <input type="text" class="form-control" name="location" 
                               value="{{ request('location') }}" 
                               placeholder="Local do óbito">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Estatísticas -->
    @if($animals->count() > 0)
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total de Óbitos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $animals->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cross fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Este Mês
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $animals->filter(function($animal) {
                                    return $animal->death_date && 
                                           Carbon\Carbon::parse($animal->death_date)->isCurrentMonth();
                                })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Este Ano
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $animals->filter(function($animal) {
                                    return $animal->death_date && 
                                           Carbon\Carbon::parse($animal->death_date)->isCurrentYear();
                                })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Média Diária
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $animals->count() > 0 ? number_format($animals->count() / max(1, $animals->pluck('death_date')->filter()->map(function($date) { return Carbon\Carbon::parse($date); })->diffInDays($animals->pluck('death_date')->filter()->map(function($date) { return Carbon\Carbon::parse($date); })->min()) + 1), 1) : '0.0' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tabela de Óbitos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Lista de Óbitos Registrados
            </h6>
            <small class="text-muted">
                Total: {{ $animals->count() }} registro(s)
            </small>
        </div>
        <div class="card-body">
            @if($animals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Animal</th>
                                <th>Categoria</th>
                                <th>Data do Óbito</th>
                                <th>Local</th>
                                <th>Causa</th>
                                <th>Registrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($animals as $animal)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm rounded-circle bg-light me-3 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-paw text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $animal->tag ?: 'Sem tag' }}</div>
                                            <small class="text-muted">
                                                @if($animal->tag)
                                                    Tag: {{ $animal->tag }} |
                                                @endif
                                                {{ ucfirst($animal->gender) }}
                                                @if($animal->is_breeder)
                                                    | {{ $animal->gender === 'macho' ? 'Reprodutor' : 'Matriz' }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($animal->category)
                                        <span class="badge bg-info">{{ $animal->category->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($animal->death_date)
                                        <div class="font-weight-bold">{{ Carbon\Carbon::parse($animal->death_date)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ Carbon\Carbon::parse($animal->death_date)->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Não informada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($animal->death_location)
                                        <span class="text-dark">{{ $animal->death_location }}</span>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($animal->death_cause)
                                        <span class="text-dark">{{ Str::limit($animal->death_cause, 80) }}</span>
                                    @else
                                        <span class="text-muted">Não informada</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $animal->updated_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('animal-deaths.show', $animal) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('animal-deaths.edit', $animal) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                onclick="reviveAnimal({{ $animal->id }}, '{{ $animal->tag }}')">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $animals->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum óbito registrado</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'start_date', 'end_date', 'location']))
                            Nenhum óbito encontrado com os filtros aplicados.
                        @else
                            Não há registros de óbitos no sistema.
                        @endif
                    </p>
                    <a href="{{ route('animal-deaths.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-2"></i>Registrar Primeiro Óbito
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Confirmação para Reviver Animal -->
<div class="modal fade" id="reviveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-heart text-success me-2"></i>Reviver Animal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente <strong>reviver</strong> o animal <span id="animalName" class="text-success font-weight-bold"></span>?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Esta ação removerá o registro de óbito e o animal voltará a estar ativo no sistema.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="reviveForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-heart me-2"></i>Confirmar Reviver
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function reviveAnimal(animalId, animalName) {
    document.getElementById('animalName').textContent = animalName;
    document.getElementById('reviveForm').action = `/animals/${animalId}/revive`;
    
    var modal = new bootstrap.Modal(document.getElementById('reviveModal'));
    modal.show();
}
</script>
@endpush
@endsection