@extends('layouts.app')
@section('title', 'Nova Pesagem')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-weight me-2"></i>Nova Pesagem</h2>
        </div>

        @if($animals->count() > 0)
            <!-- Alerta informativo -->
            <div class="alert alert-info mb-4" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Atenção:</strong> Apenas animais com compra registrada e que <strong>não foram vendidos</strong> podem ter pesagens registradas.
            </div>
            
            <div class="modern-form-container">
                <form action="{{ route('animal-weights.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Animal *</label>
                                <select name="animal_id" class="modern-form-control @error('animal_id') is-invalid @enderror" required>
                                    <option value="">Selecione um animal</option>
                                    @foreach ($animals as $animal)
                                        <option value="{{ $animal->id }}" {{ old('animal_id') == $animal->id ? 'selected' : '' }}>
                                            {{ $animal->tag }}
                                            @if($animal->breed) - {{ $animal->breed }} @endif
                                            @if($animal->purchase) - Comprado por R$ {{ number_format($animal->purchase->value, 2, ',', '.') }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('animal_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Apenas animais com compra registrada e não vendidos podem ter pesagens.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Peso (kg) *</label>
                                <input type="number" name="weight" step="0.01" class="modern-form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}" required>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Data da Pesagem *</label>
                                <input type="date" name="recorded_at" class="modern-form-control @error('recorded_at') is-invalid @enderror" value="{{ old('recorded_at', date('Y-m-d')) }}" required>
                                @error('recorded_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modern-form-actions">
                        <button type="submit" class="modern-btn modern-btn-success">
                            <i class="fas fa-save"></i>
                            Registrar Pesagem
                        </button>
                        <a href="{{ route('animal-weights.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        @else
            <div class="alert alert-warning">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-2">Nenhum animal disponível para pesagem</h5>
                        <p class="mb-0">
                            Para registrar uma pesagem, é necessário que o animal tenha uma <strong>compra registrada</strong> e <strong>não tenha sido vendido</strong>.
                            <br>
                            Acesse <a href="{{ route('purchases.create') }}" class="alert-link">Registrar Compra</a> para adicionar animais ao estoque.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('purchases.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-shopping-cart"></i>
                    Registrar Compra de Animal
                </a>
                <a href="{{ route('animal-weights.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar para Pesagens
                </a>
            </div>
        @endif
    </div>
@endsection
