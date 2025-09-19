@extends('layouts.app')
@section('title', 'Nova Alimentação')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-seedling me-2"></i>Nova Alimentação</h2>
        </div>

        @if($animals->count() > 0)
            <div class="modern-form-container">
                <form action="{{ route('feedings.store') }}" method="POST">
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
                                    Apenas animais com compra registrada podem ter alimentações.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Tipo de Alimento *</label>
                                <input type="text" name="feed_type" class="modern-form-control @error('feed_type') is-invalid @enderror" value="{{ old('feed_type') }}" required>
                                @error('feed_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Quantidade *</label>
                                <input type="number" name="quantity" step="0.01" class="modern-form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Data da Alimentação *</label>
                                <input type="date" name="feeding_date" class="modern-form-control @error('feeding_date') is-invalid @enderror" value="{{ old('feeding_date', date('Y-m-d')) }}" required>
                                @error('feeding_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modern-form-actions">
                        <button type="submit" class="modern-btn modern-btn-success">
                            <i class="fas fa-save"></i>
                            Registrar Alimentação
                        </button>
                        <a href="{{ route('feedings.index') }}" class="modern-btn modern-btn-secondary">
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
                        <h5 class="alert-heading mb-2">Nenhum animal disponível para alimentação</h5>
                        <p class="mb-0">
                            Para registrar uma alimentação, é necessário que o animal tenha uma <strong>compra registrada</strong> primeiro.
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
                <a href="{{ route('feedings.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar para Alimentações
                </a>
            </div>
        @endif
    </div>
@endsection
