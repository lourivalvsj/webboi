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
                                @if($feedTypes->count() > 0)
                                    <select name="feed_type" class="modern-form-control @error('feed_type') is-invalid @enderror" required>
                                        <option value="">Selecione um alimento</option>
                                        @foreach ($feedTypes as $feedType)
                                            <option value="{{ $feedType }}" {{ old('feed_type') == $feedType ? 'selected' : '' }}>
                                                {{ $feedType }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Apenas produtos cadastrados em "Gastos com Insumos" aparecem aqui.
                                    </small>
                                @else
                                    <select name="feed_type" class="modern-form-control" disabled>
                                        <option value="">Nenhum produto cadastrado</option>
                                    </select>
                                    <small class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        É necessário cadastrar produtos em <a href="{{ route('supply-expenses.create') }}">Gastos com Insumos</a> primeiro.
                                    </small>
                                @endif
                                @error('feed_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Quantidade *</label>
                                <input type="number" name="quantity" step="0.01" class="modern-form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Unidade de Medida</label>
                                <select name="unit_of_measure" class="modern-form-control @error('unit_of_measure') is-invalid @enderror">
                                    <option value="">Selecione a unidade</option>
                                    <option value="kg" {{ old('unit_of_measure') == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                                    <option value="g" {{ old('unit_of_measure') == 'g' ? 'selected' : '' }}>Grama (g)</option>
                                    <option value="t" {{ old('unit_of_measure') == 't' ? 'selected' : '' }}>Tonelada (t)</option>
                                    <option value="l" {{ old('unit_of_measure') == 'l' ? 'selected' : '' }}>Litro (l)</option>
                                    <option value="ml" {{ old('unit_of_measure') == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                                    <option value="balde" {{ old('unit_of_measure') == 'balde' ? 'selected' : '' }}>Balde</option>
                                    <option value="saco" {{ old('unit_of_measure') == 'saco' ? 'selected' : '' }}>Saco</option>
                                    <option value="fardo" {{ old('unit_of_measure') == 'fardo' ? 'selected' : '' }}>Fardo</option>
                                    <option value="unidade" {{ old('unit_of_measure') == 'unidade' ? 'selected' : '' }}>Unidade</option>
                                </select>
                                @error('unit_of_measure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
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
