@extends('layouts.app')

@section('title', 'Editar Venda')
@section('content')
    <div class="container">
        <h2>Editar Venda</h2>

        <form action="{{ route('sales.update', $sale) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Animal</label>
                <select name="animal_id" class="form-control">
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}" {{ $sale->animal_id == $animal->id ? 'selected' : '' }}>
                            {{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Comprador</label>
                <select name="buyer_id" class="form-control">
                    @foreach ($buyers as $buyer)
                        <option value="{{ $buyer->id }}" {{ $sale->buyer_id == $buyer->id ? 'selected' : '' }}>
                            {{ $buyer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Data da Venda</label>
                <input type="date" name="sale_date" value="{{ $sale->sale_date }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Valor da Venda (R$)</label>
                <input type="number" step="0.01" name="value" value="{{ $sale->value }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
