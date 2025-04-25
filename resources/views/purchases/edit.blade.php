@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Compra</h2>

        <form action="{{ route('purchases.update', $purchase) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Animal</label>
                <select name="animal_id" class="form-control">
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}" {{ $purchase->animal_id == $animal->id ? 'selected' : '' }}>
                            {{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Vendedor</label>
                <select name="vendor_id" class="form-control">
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $purchase->vendor_id == $vendor->id ? 'selected' : '' }}>
                            {{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Data da Compra</label>
                <input type="date" name="purchase_date" value="{{ $purchase->purchase_date }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Valor da Compra (R$)</label>
                <input type="number" step="0.01" name="value" value="{{ $purchase->value }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
