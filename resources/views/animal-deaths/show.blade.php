@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-eye text-info me-3" style="font-size: 2rem;"></i>
            <div>
                <h1 class="h3 mb-0 text-gray-800">Detalhes do Óbito</h1>
                <p class="text-muted mb-0">Informações completas sobre o registro de óbito</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('animal-deaths.edit', $animal) }}" class="btn btn-secondary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <button type="button" class="btn btn-success"
                    onclick="reviveAnimal({{ $animal->id }}, '{{ $animal->tag }}')">
                <i class="fas fa-heart me-2"></i>Reviver
            </button>
            <a href="{{ route('animal-deaths.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informações do Animal -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-paw me-2"></i>Informações do Animal
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nome do Animal</label>
                                <div class="fs-5 font-weight-bold">{{ $animal->tag ?: 'Sem tag' }}</div>
                            </div>
                            @if($animal->tag)
                            <div class="mb-3">
                                <label class="form-label text-muted">Tag/Identificação</label>
                                <div class="fs-6">
                                    <span class="badge bg-primary">{{ $animal->tag }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label text-muted">Categoria</label>
                                <div class="fs-6">
                                    @if($animal->category)
                                        <span class="badge bg-info">{{ $animal->category->name }}</span>
                                    @else
                                        <span class="text-muted">Não informada</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Gênero</label>
                                <div class="fs-6">
                                    <i class="fas fa-{{ $animal->gender === 'macho' ? 'mars text-primary' : 'venus text-danger' }} me-2"></i>
                                    {{ ucfirst($animal->gender) }}
                                    @if($animal->is_breeder)
                                        <span class="badge bg-success ms-2">
                                            {{ $animal->gender === 'macho' ? 'Reprodutor' : 'Matriz' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Data de Nascimento</label>
                                <div class="fs-6">
                                    @if($animal->birth_date)
                                        {{ Carbon\Carbon::parse($animal->birth_date)->format('d/m/Y') }}
                                        <small class="text-muted">
                                            ({{ Carbon\Carbon::parse($animal->birth_date)->age }} anos)
                                        </small>
                                    @else
                                        <span class="text-muted">Não informada</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Peso Atual</label>
                                <div class="fs-6">
                                    @if($animal->current_weight)
                                        <strong>{{ number_format($animal->current_weight, 1) }} kg</strong>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalhes do Óbito -->
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-cross me-2"></i>Detalhes do Óbito
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted">
                                    <i class="fas fa-calendar me-2"></i>Data do Óbito
                                </label>
                                <div class="fs-5 text-danger font-weight-bold">
                                    @if($animal->death_date)
                                        {{ Carbon\Carbon::parse($animal->death_date)->format('d/m/Y') }}
                                        <div class="fs-6 text-muted font-weight-normal">
                                            {{ Carbon\Carbon::parse($animal->death_date)->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-muted fs-6">Data não informada</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i>Local da Morte
                                </label>
                                <div class="fs-6">
                                    @if($animal->death_location)
                                        <span class="text-dark font-weight-bold">{{ $animal->death_location }}</span>
                                    @else
                                        <span class="text-muted">Local não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted">
                                    <i class="fas fa-stethoscope me-2"></i>Causa da Morte
                                </label>
                                <div class="fs-6">
                                    @if($animal->death_cause)
                                        <span class="text-dark font-weight-bold">{{ $animal->death_cause }}</span>
                                    @else
                                        <span class="text-muted">Causa não informada</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted">
                                    <i class="fas fa-clock me-2"></i>Registrado em
                                </label>
                                <div class="fs-6">
                                    {{ $animal->updated_at->format('d/m/Y H:i') }}
                                    <small class="text-muted d-block">
                                        {{ $animal->updated_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($animal->death_observations)
                    <div class="mt-4">
                        <label class="form-label text-muted">
                            <i class="fas fa-notes-medical me-2"></i>Observações Detalhadas
                        </label>
                        <div class="border rounded p-3 bg-light">
                            <div class="text-dark" style="white-space: pre-wrap;">{{ $animal->death_observations }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Painel Lateral -->
        <div class="col-lg-4">
            <!-- Status -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Status do Animal
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-cross fa-3x text-danger mb-2"></i>
                        <div class="fs-4 font-weight-bold text-danger">MORTO</div>
                        @if($animal->death_date)
                        <small class="text-muted">
                            Há {{ Carbon\Carbon::parse($animal->death_date)->diffForHumans(null, true) }}
                        </small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Histórico Recente -->
            @php
                $recentWeights = $animal->animalWeights()->latest()->limit(3)->get();
                $recentFeedings = $animal->feedings()->latest()->limit(3)->get();
                $recentMedications = $animal->medications()->latest()->limit(3)->get();
            @endphp

            @if($recentWeights->count() > 0 || $recentFeedings->count() > 0 || $recentMedications->count() > 0)
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-history me-2"></i>Últimos Registros
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentWeights->count() > 0)
                    <div class="mb-3">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-weight me-1"></i> Pesagens
                        </h6>
                        @foreach($recentWeights as $weight)
                        <div class="d-flex justify-content-between mb-1">
                            <small>{{ $weight->created_at->format('d/m/Y') }}</small>
                            <small><strong>{{ number_format($weight->weight, 1) }}kg</strong></small>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($recentFeedings->count() > 0)
                    <div class="mb-3">
                        <h6 class="text-success mb-2">
                            <i class="fas fa-utensils me-1"></i> Alimentação
                        </h6>
                        @foreach($recentFeedings as $feeding)
                        <div class="d-flex justify-content-between mb-1">
                            <small>{{ $feeding->created_at->format('d/m/Y') }}</small>
                            <small><strong>{{ number_format($feeding->quantity, 1) }}kg</strong></small>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($recentMedications->count() > 0)
                    <div class="mb-0">
                        <h6 class="text-orange mb-2">
                            <i class="fas fa-pills me-1"></i> Medicações
                        </h6>
                        @foreach($recentMedications as $medication)
                        <div class="d-flex justify-content-between mb-1">
                            <small>{{ $medication->created_at->format('d/m/Y') }}</small>
                            <small><strong>{{ $medication->type }}</strong></small>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
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