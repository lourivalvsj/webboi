@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-plus-circle text-danger me-3" style="font-size: 2rem;"></i>
            <div>
                <h1 class="h3 mb-0 text-gray-800">Registrar Óbito</h1>
                <p class="text-muted mb-0">Registrar morte de animal com detalhes do ocorrido</p>
            </div>
        </div>
        <div class="d-flex gap-2">
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
                    <form action="{{ route('animal-deaths.store') }}" method="POST">
                        @csrf

                        <!-- Seleção do Animal -->
                        <div class="mb-4">
                            <label for="animal_id" class="form-label">
                                <i class="fas fa-paw me-2"></i>Animal *
                            </label>
                            <select name="animal_id" id="animal_id" class="form-select @error('animal_id') is-invalid @enderror" required>
                                <option value="">Selecione o animal que morreu</option>
                                @foreach($animals as $animal)
                                    <option value="{{ $animal->id }}" 
                                            data-category="{{ $animal->category->name ?? 'Sem categoria' }}"
                                            data-gender="{{ $animal->gender }}"
                                            data-breeder="{{ $animal->is_breeder ? 'true' : 'false' }}"
                                            {{ old('animal_id') == $animal->id ? 'selected' : '' }}>
                                        {{ $animal->tag ?: 'Sem tag' }}
                                        @if($animal->breed) - Raça: {{ $animal->breed }} @endif
                                        ({{ ucfirst($animal->gender) }}{{ $animal->is_breeder ? ($animal->gender === 'macho' ? ' - Reprodutor' : ' - Matriz') : '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('animal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informações do Animal Selecionado -->
                        <div id="animalInfo" class="alert alert-info" style="display: none;">
                            <h6><i class="fas fa-info-circle me-2"></i>Informações do Animal</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Categoria:</strong> <span id="animalCategory"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Classificação:</strong> <span id="animalClassification"></span>
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
                                       value="{{ old('death_date', date('Y-m-d')) }}" 
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
                                       value="{{ old('death_location') }}" 
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
                                   value="{{ old('death_cause') }}" 
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
                                      rows="4"
                                      class="form-control @error('death_observations') is-invalid @enderror"
                                      placeholder="Descreva detalhes sobre as circunstâncias da morte, sintomas observados, tratamentos realizados, etc.">{{ old('death_observations') }}</textarea>
                            @error('death_observations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('animal-deaths.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-cross me-2"></i>Registrar Óbito
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Painel de Informações -->
        <div class="col-lg-4">
            <!-- Avisos Importantes -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0 text-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>Avisos Importantes
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong><i class="fas fa-info-circle me-2"></i>Importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Apenas animais <strong>vivos</strong> podem ter óbito registrado</li>
                            <li>Animais <strong>já vendidos</strong> não podem ter óbito registrado</li>
                            <li>Data do óbito não pode ser futura</li>
                            <li>Uma vez registrado, o animal sairá das listagens ativas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Estatísticas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Animais Vivos:</span>
                            <strong class="text-success">{{ $aliveCount }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Óbitos Registrados:</span>
                            <strong class="text-danger">{{ $deadCount }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total de Animais:</span>
                            <strong>{{ $totalCount }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between">
                            <span>Taxa de Mortalidade:</span>
                            <strong class="text-info">
                                {{ $totalCount > 0 ? number_format(($deadCount / $totalCount) * 100, 1) : 0 }}%
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('animal_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const animalInfo = document.getElementById('animalInfo');
    
    if (this.value) {
        const category = selectedOption.getAttribute('data-category');
        const gender = selectedOption.getAttribute('data-gender');
        const isBreeder = selectedOption.getAttribute('data-breeder') === 'true';
        
        document.getElementById('animalCategory').textContent = category;
        
        let classification = gender === 'macho' ? 'Macho' : 'Fêmea';
        if (isBreeder) {
            classification += gender === 'macho' ? ' Reprodutor' : ' Matriz';
        }
        document.getElementById('animalClassification').textContent = classification;
        
        animalInfo.style.display = 'block';
    } else {
        animalInfo.style.display = 'none';
    }
});
</script>
@endpush
@endsection