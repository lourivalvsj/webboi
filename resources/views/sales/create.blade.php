@extends('layouts.app')

@section('title', 'Nova Venda')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-hand-holding-usd me-2"></i>Nova Venda</h2>
        </div>

        @if($animals->count() > 0)
            <div class="modern-form-container">
                <form action="{{ route('sales.store') }}" method="POST">
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
                                    Apenas animais com compra registrada e que ainda não foram vendidos aparecem nesta lista.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Comprador</label>
                                <select name="buyer_id" class="modern-form-control @error('buyer_id') is-invalid @enderror">
                                    <option value="">Selecione um comprador</option>
                                    @foreach ($buyers as $buyer)
                                        <option value="{{ $buyer->id }}" {{ old('buyer_id') == $buyer->id ? 'selected' : '' }}>
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
                                <input type="date" name="sale_date" class="modern-form-control @error('sale_date') is-invalid @enderror" value="{{ old('sale_date', date('Y-m-d')) }}">
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="modern-form-group">
                                <label class="modern-form-label">Valor da Venda (R$) *</label>
                                <input type="number" step="0.01" name="value" class="modern-form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modern-form-actions">
                        <button type="submit" class="modern-btn modern-btn-success">
                            <i class="fas fa-save"></i>
                            Registrar Venda
                        </button>
                        <a href="{{ route('sales.index') }}" class="modern-btn modern-btn-secondary">
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
                        <h5 class="alert-heading mb-2">Nenhum animal disponível para venda</h5>
                        <p class="mb-0">
                            Para registrar uma venda, é necessário que o animal tenha uma <strong>compra registrada</strong> primeiro.
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
                <a href="{{ route('sales.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar para Vendas
                </a>
            </div>
        @endif
    </div>
@endsection
