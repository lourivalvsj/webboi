@extends('layouts.app')
@section('title', 'Nova Medicação')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-pills me-2"></i>Nova Medicação</h2>
        </div>

        @if($animals->count() > 0)
            <div class="modern-form-container">
                <form action="{{ route('medications.store') }}" method="POST">
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
                                    Apenas animais com compra registrada podem ter medicações.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Nome do Medicamento *</label>
                                @if($medicationNames->count() > 0)
                                    <select name="medication_name" class="modern-form-control @error('medication_name') is-invalid @enderror" required>
                                        <option value="">Selecione um medicamento</option>
                                        @foreach ($medicationNames as $medicationName)
                                            <option value="{{ $medicationName }}" {{ old('medication_name') == $medicationName ? 'selected' : '' }}>
                                                {{ $medicationName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Apenas produtos cadastrados em "Gastos com Insumos" aparecem aqui.
                                    </small>
                                @else
                                    <select name="medication_name" class="modern-form-control" disabled>
                                        <option value="">Nenhum produto cadastrado</option>
                                    </select>
                                    <small class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        É necessário cadastrar produtos em <a href="{{ route('supply-expenses.create') }}">Gastos com Insumos</a> primeiro.
                                    </small>
                                @endif
                                @error('medication_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Quantidade *</label>
                                <input type="number" step="0.001" name="dose" class="modern-form-control @error('dose') is-invalid @enderror" value="{{ old('dose') }}" required placeholder="Ex: 2.5">
                                @error('dose')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Unidade de Medida</label>
                                <select name="unit_of_measure" class="modern-form-control @error('unit_of_measure') is-invalid @enderror">
                                    <option value="">Selecione a unidade</option>
                                    <option value="ml" {{ old('unit_of_measure') == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                                    <option value="l" {{ old('unit_of_measure') == 'l' ? 'selected' : '' }}>Litro (l)</option>
                                    <option value="mg" {{ old('unit_of_measure') == 'mg' ? 'selected' : '' }}>Miligrama (mg)</option>
                                    <option value="g" {{ old('unit_of_measure') == 'g' ? 'selected' : '' }}>Grama (g)</option>
                                    <option value="kg" {{ old('unit_of_measure') == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                                    <option value="dose" {{ old('unit_of_measure') == 'dose' ? 'selected' : '' }}>Dose</option>
                                    <option value="comprimido" {{ old('unit_of_measure') == 'comprimido' ? 'selected' : '' }}>Comprimido</option>
                                    <option value="capsula" {{ old('unit_of_measure') == 'capsula' ? 'selected' : '' }}>Cápsula</option>
                                    <option value="ampola" {{ old('unit_of_measure') == 'ampola' ? 'selected' : '' }}>Ampola</option>
                                    <option value="frasco" {{ old('unit_of_measure') == 'frasco' ? 'selected' : '' }}>Frasco</option>
                                    <option value="aplicacao" {{ old('unit_of_measure') == 'aplicacao' ? 'selected' : '' }}>Aplicação</option>
                                </select>
                                @error('unit_of_measure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Data da Administração *</label>
                                <input type="date" name="administration_date" class="modern-form-control @error('administration_date') is-invalid @enderror" value="{{ old('administration_date', date('Y-m-d')) }}" required>
                                @error('administration_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modern-form-actions">
                        <button type="submit" class="modern-btn modern-btn-success">
                            <i class="fas fa-save"></i>
                            Registrar Medicação
                        </button>
                        <a href="{{ route('medications.index') }}" class="modern-btn modern-btn-secondary">
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
                        <h5 class="alert-heading mb-2">Nenhum animal disponível para medicação</h5>
                        <p class="mb-0">
                            Para registrar uma medicação, é necessário que o animal tenha uma <strong>compra registrada</strong> primeiro.
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
                <a href="{{ route('medications.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar para Medicações
                </a>
            </div>
        @endif
    </div>
@endsection
