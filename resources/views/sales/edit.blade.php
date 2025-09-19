@extends('layouts.app')

@section('title', 'Editar Venda')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-edit me-2"></i>Editar Venda #{{ $sale->id }}</h2>
        </div>

        <div class="modern-form-container">
            <form action="{{ route('sales.update', $sale) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label class="modern-form-label">Animal *</label>
                            <select name="animal_id" class="modern-form-control @error('animal_id') is-invalid @enderror" required>
                                <option value="">Selecione um animal</option>
                                @foreach ($animals as $animal)
                                    <option value="{{ $animal->id }}" {{ $sale->animal_id == $animal->id ? 'selected' : '' }}>
                                        {{ $animal->tag }} 
                                        @if($animal->breed) - {{ $animal->breed }} @endif
                                        @if($animal->purchase) - Comprado por R$ {{ number_format($animal->purchase->value, 2, ',', '.') }} @endif
                                    </option>
                                @endforeach
                                <!-- Incluir o animal atual da venda mesmo que já vendido (para permitir edição) -->
                                @if($sale->animal && !$animals->contains('id', $sale->animal->id))
                                    <option value="{{ $sale->animal->id }}" selected>
                                        {{ $sale->animal->tag }} 
                                        @if($sale->animal->breed) - {{ $sale->animal->breed }} @endif
                                        (Animal atual da venda)
                                    </option>
                                @endif
                            </select>
                            @error('animal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Apenas animais com compra registrada e disponíveis para venda.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label class="modern-form-label">Comprador</label>
                            <select name="buyer_id" class="modern-form-control @error('buyer_id') is-invalid @enderror">
                                <option value="">Selecione um comprador</option>
                                @foreach ($buyers as $buyer)
                                    <option value="{{ $buyer->id }}" {{ $sale->buyer_id == $buyer->id ? 'selected' : '' }}>
                                        {{ $buyer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('buyer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label class="modern-form-label">Data da Venda</label>
                            <input type="date" name="sale_date" value="{{ $sale->sale_date ? $sale->sale_date->format('Y-m-d') : '' }}" class="modern-form-control @error('sale_date') is-invalid @enderror">
                            @error('sale_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label class="modern-form-label">Valor da Venda (R$) *</label>
                            <input type="number" step="0.01" name="value" value="{{ $sale->value }}" class="modern-form-control @error('value') is-invalid @enderror" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modern-form-actions">
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Atualizar Venda
                    </button>
                    <a href="{{ route('sales.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
