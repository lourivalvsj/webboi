@extends('layouts.app')

@section('title', 'Editar Compra')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <h2><i class="fas fa-edit me-2"></i>Editar Compra</h2>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('purchases.update', $purchase) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Animal *</label>
                        <select name="animal_id" class="modern-form-control" required>
                            <option value="">Selecione o animal</option>
                            @foreach ($animals as $animal)
                                <option value="{{ $animal->id }}" {{ old('animal_id', $purchase->animal_id) == $animal->id ? 'selected' : '' }}>
                                    {{ $animal->tag }} - {{ $animal->name ?? 'Sem nome' }}
                                </option>
                            @endforeach
                        </select>
                        @error('animal_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Vendedor</label>
                        <select name="vendor_id" class="modern-form-control">
                            <option value="">Selecione o vendedor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id', $purchase->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Data da Compra</label>
                        <input type="date" name="purchase_date" class="modern-form-control" value="{{ old('purchase_date', $purchase->purchase_date) }}">
                        @error('purchase_date')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Valor da Compra (R$) *</label>
                        <input type="number" step="0.01" name="value" class="modern-form-control" value="{{ old('value', $purchase->value) }}" required>
                        @error('value')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Custo do Frete (R$)</label>
                        <input type="number" step="0.01" name="freight_cost" class="modern-form-control" value="{{ old('freight_cost', $purchase->freight_cost) }}">
                        @error('freight_cost')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Transportador</label>
                        <input type="text" name="transporter" class="modern-form-control" value="{{ old('transporter', $purchase->transporter) }}">
                        @error('transporter')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Valor da Comissão (R$)</label>
                        <input type="number" step="0.01" name="commission_value" class="modern-form-control" value="{{ old('commission_value', $purchase->commission_value) }}">
                        @error('commission_value')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Percentual da Comissão (%)</label>
                        <input type="number" step="0.01" max="100" name="commission_percent" class="modern-form-control" value="{{ old('commission_percent', $purchase->commission_percent) }}">
                        @error('commission_percent')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modern-form-actions">
                <button type="submit" class="modern-btn modern-btn-primary" style="opacity: 1 !important; visibility: visible !important; background: linear-gradient(45deg, #667eea, #764ba2) !important; color: white !important; border: none !important;">
                    <i class="fas fa-save"></i>
                    Atualizar Compra
                </button>
                <a href="{{ route('purchases.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
