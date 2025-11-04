@extends('layouts.app')

@section('title', 'Editar Gasto com Insumo')
@section('content')
    <div class="container">
        <h2>Editar Gasto com Insumo</h2>
        <form action="{{ route('supply-expenses.update', $supplyExpense) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome do Gasto</label>
                <input type="text" name="name" value="{{ $supplyExpense->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Categoria *</label>
                <select name="category" class="form-select" required>
                    <option value="">Selecione a categoria</option>
                    @foreach(App\Models\SupplyExpense::getCategories() as $key => $label)
                        <option value="{{ $key }}" {{ $supplyExpense->category == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
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

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantidade</label>
                        <input type="number" step="0.001" name="quantity" value="{{ $supplyExpense->quantity }}" class="form-control" placeholder="Ex: 25">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="unit_of_measure" class="form-label">Unidade de Medida</label>
                        <select name="unit_of_measure" class="form-select">
                            <option value="">Selecione a unidade</option>
                            <option value="kg" {{ $supplyExpense->unit_of_measure == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                            <option value="g" {{ $supplyExpense->unit_of_measure == 'g' ? 'selected' : '' }}>Grama (g)</option>
                            <option value="t" {{ $supplyExpense->unit_of_measure == 't' ? 'selected' : '' }}>Tonelada (t)</option>
                            <option value="l" {{ $supplyExpense->unit_of_measure == 'l' ? 'selected' : '' }}>Litro (l)</option>
                            <option value="ml" {{ $supplyExpense->unit_of_measure == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                            <option value="m" {{ $supplyExpense->unit_of_measure == 'm' ? 'selected' : '' }}>Metro (m)</option>
                            <option value="cm" {{ $supplyExpense->unit_of_measure == 'cm' ? 'selected' : '' }}>Centímetro (cm)</option>
                            <option value="unidade" {{ $supplyExpense->unit_of_measure == 'unidade' ? 'selected' : '' }}>Unidade</option>
                            <option value="pacote" {{ $supplyExpense->unit_of_measure == 'pacote' ? 'selected' : '' }}>Pacote</option>
                            <option value="saco" {{ $supplyExpense->unit_of_measure == 'saco' ? 'selected' : '' }}>Saco</option>
                            <option value="caixa" {{ $supplyExpense->unit_of_measure == 'caixa' ? 'selected' : '' }}>Caixa</option>
                            <option value="outro" {{ $supplyExpense->unit_of_measure == 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('supply-expenses.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
