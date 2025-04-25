@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Gasto com Insumo</h2>
        <form action="{{ route('supply-expenses.update', $supplyExpense) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="animal_id" class="form-label">Animal</label>
                <select name="animal_id" class="form-select" required>
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}" {{ $supplyExpense->animal_id == $animal->id ? 'selected' : '' }}>
                            {{ $animal->tag ?? 'Sem identificação' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome do Gasto</label>
                <input type="text" name="name" value="{{ $supplyExpense->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="3">{{ $supplyExpense->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">Data da Compra</label>
                <input type="date" name="purchase_date" value="{{ $supplyExpense->purchase_date }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" name="value" value="{{ $supplyExpense->value }}" class="form-control"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('supply-expenses.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
