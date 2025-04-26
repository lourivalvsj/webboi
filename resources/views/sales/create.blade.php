@extends('layouts.app')

@section('title', 'Nova Venda')
@section('content')
    <div class="container">
        <h2>Nova Venda</h2>

        <form action="{{ route('sales.store') }}" method="POST">
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
                <label class="form-label">Comprador</label>
                <select name="buyer_id" class="form-control">
                    @foreach ($buyers as $buyer)
                        <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Data da Venda</label>
                <input type="date" name="sale_date" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Valor da Venda (R$)</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
