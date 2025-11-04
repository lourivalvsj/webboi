@extends('layouts.app')

@section('title', 'Editar Despesa Operacional')
@section('content')
    <div class="container">
        <h2>Editar Despesa Operacional</h2>
        <form action="{{ route('operational-expenses.update', $operationalExpense) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="local_id" class="form-label">Local</label>
                <select name="local_id" class="form-select" required>
                    @foreach ($locals as $local)
                        <option value="{{ $local->id }}"
                            {{ $operationalExpense->local_id == $local->id ? 'selected' : '' }}>
                            {{ $local->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Despesa</label>
                <input type="text" name="name" value="{{ $operationalExpense->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" name="value" value="{{ $operationalExpense->value }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Data</label>
                <input type="date" name="date" value="{{ $operationalExpense->date }}" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantidade</label>
                        <input type="number" step="0.001" name="quantity" value="{{ $operationalExpense->quantity }}" class="form-control" placeholder="Ex: 25">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="unit_of_measure" class="form-label">Unidade de Medida</label>
                        <select name="unit_of_measure" class="form-select">
                            <option value="">Selecione a unidade</option>
                            <option value="kg" {{ $operationalExpense->unit_of_measure == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                            <option value="g" {{ $operationalExpense->unit_of_measure == 'g' ? 'selected' : '' }}>Grama (g)</option>
                            <option value="t" {{ $operationalExpense->unit_of_measure == 't' ? 'selected' : '' }}>Tonelada (t)</option>
                            <option value="l" {{ $operationalExpense->unit_of_measure == 'l' ? 'selected' : '' }}>Litro (l)</option>
                            <option value="ml" {{ $operationalExpense->unit_of_measure == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                            <option value="m" {{ $operationalExpense->unit_of_measure == 'm' ? 'selected' : '' }}>Metro (m)</option>
                            <option value="cm" {{ $operationalExpense->unit_of_measure == 'cm' ? 'selected' : '' }}>Centímetro (cm)</option>
                            <option value="m²" {{ $operationalExpense->unit_of_measure == 'm²' ? 'selected' : '' }}>Metro quadrado (m²)</option>
                            <option value="m³" {{ $operationalExpense->unit_of_measure == 'm³' ? 'selected' : '' }}>Metro cúbico (m³)</option>
                            <option value="unidade" {{ $operationalExpense->unit_of_measure == 'unidade' ? 'selected' : '' }}>Unidade</option>
                            <option value="pacote" {{ $operationalExpense->unit_of_measure == 'pacote' ? 'selected' : '' }}>Pacote</option>
                            <option value="saco" {{ $operationalExpense->unit_of_measure == 'saco' ? 'selected' : '' }}>Saco</option>
                            <option value="caixa" {{ $operationalExpense->unit_of_measure == 'caixa' ? 'selected' : '' }}>Caixa</option>
                            <option value="hora" {{ $operationalExpense->unit_of_measure == 'hora' ? 'selected' : '' }}>Hora</option>
                            <option value="dia" {{ $operationalExpense->unit_of_measure == 'dia' ? 'selected' : '' }}>Dia</option>
                            <option value="mês" {{ $operationalExpense->unit_of_measure == 'mês' ? 'selected' : '' }}>Mês</option>
                            <option value="serviço" {{ $operationalExpense->unit_of_measure == 'serviço' ? 'selected' : '' }}>Serviço</option>
                            <option value="outro" {{ $operationalExpense->unit_of_measure == 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('operational-expenses.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
