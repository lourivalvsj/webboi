@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-edit text-warning me-3" style="font-size: 2rem;"></i>
            <div>
                <h1 class="h3 mb-0 text-gray-800">Editar Óbito</h1>
                <p class="text-muted mb-0">Alterar informações do registro de óbito de {{ $animal->tag ?: 'Sem tag' }}</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('animal-deaths.show', $animal) }}" class="btn btn-info">
                <i class="fas fa-eye me-2"></i>Visualizar
            </a>
            <a href="{{ route('animal-deaths.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Formulário -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-cross me-2"></i>Dados do Óbito
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('animal-deaths.update', $animal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Informações do Animal (somente leitura) -->
                        <div class="alert alert-info mb-4">
                            <h6><i class="fas fa-paw me-2"></i>Animal</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tag:</strong> {{ $animal->tag ?: 'Sem tag' }}<br>
                                    @if($animal->tag)
                                        <strong>Tag:</strong> {{ $animal->tag }}<br>
                                    @endif
                                    <strong>Categoria:</strong> {{ $animal->category->name ?? 'Não informada' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Gênero:</strong> {{ ucfirst($animal->gender) }}
                                    @if($animal->is_breeder)
                                        ({{ $animal->gender === 'macho' ? 'Reprodutor' : 'Matriz' }})
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Data do Óbito -->
                            <div class="col-md-6 mb-3">
                                <label for="death_date" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Data do Óbito *
                                </label>
                                <input type="date" 
                                       name="death_date" 
                                       id="death_date" 
                                       class="form-control @error('death_date') is-invalid @enderror"
                                       value="{{ old('death_date', $animal->death_date ? Carbon\Carbon::parse($animal->death_date)->format('Y-m-d') : '') }}" 
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('death_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Local da Morte -->
                            <div class="col-md-6 mb-3">
                                <label for="death_location" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Local da Morte
                                </label>
                                <input type="text" 
                                       name="death_location" 
                                       id="death_location" 
                                       class="form-control @error('death_location') is-invalid @enderror"
                                       value="{{ old('death_location', $animal->death_location) }}" 
                                       placeholder="Ex: Pasto 1, Estábulo A, Enfermaria">
                                @error('death_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Causa da Morte -->
                        <div class="mb-3">
                            <label for="death_cause" class="form-label">
                                <i class="fas fa-stethoscope me-2"></i>Causa da Morte
                            </label>
                            <input type="text" 
                                   name="death_cause" 
                                   id="death_cause" 
                                   class="form-control @error('death_cause') is-invalid @enderror"
                                   value="{{ old('death_cause', $animal->death_cause) }}" 
                                   placeholder="Ex: Doença respiratória, Acidente, Causas naturais">
                            @error('death_cause')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Observações -->
                        <div class="mb-4">
                            <label for="death_observations" class="form-label">
                                <i class="fas fa-notes-medical me-2"></i>Observações Detalhadas
                            </label>
                            <textarea name="death_observations" 
                                      id="death_observations" 
                                      rows="5"
                                      class="form-control @error('death_observations') is-invalid @enderror"
                                      placeholder="Descreva detalhes sobre as circunstâncias da morte, sintomas observados, tratamentos realizados, etc.">{{ old('death_observations', $animal->death_observations) }}</textarea>
                            @error('death_observations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('animal-deaths.show', $animal) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Painel Lateral -->
        <div class="col-lg-4">
            <!-- Status Atual -->
            <div class="card shadow mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-cross me-2"></i>Status Atual
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-cross fa-3x text-danger mb-2"></i>
                        <div class="fs-4 font-weight-bold text-danger">MORTO</div>
                        @if($animal->death_date)
                        <small class="text-muted">
                            Registrado há {{ Carbon\Carbon::parse($animal->death_date)->diffForHumans(null, true) }}
                        </small>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-sm"
                                onclick="reviveAnimal({{ $animal->id }}, '{{ $animal->tag }}')">
                            <i class="fas fa-heart me-2"></i>Reviver Animal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Informações do Registro -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informações do Registro
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Registrado em:</span>
                            <strong>{{ $animal->updated_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Última alteração:</span>
                            <strong>{{ $animal->updated_at->diffForHumans() }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Avisos -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0 text-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>Avisos
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <ul class="mb-0">
                            <li>Data do óbito não pode ser futura</li>
                            <li>Alterações serão registradas no histórico</li>
                            <li>Animal permanecerá inativo após edição</li>
                            <li>Use "Reviver" para reativar o animal</li>
                        </ul>
                    </div>
                </div>
            </div>
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