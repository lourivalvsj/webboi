@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nova Compra</h2>

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Animal</label>
                <select name="animal_id" class="form-control" required>
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Vendedor</label>
                <select name="vendor_id" class="form-control">
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Data da Compra</label>
                <input type="date" name="purchase_date" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
