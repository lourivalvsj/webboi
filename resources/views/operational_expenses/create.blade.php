@extends('layouts.app')

@section('title', 'Nova Despesa Operacional')
@section('content')
    <div class="container">
        <h2>Nova Despesa Operacional</h2>
        <form action="{{ route('operational-expenses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="local_id" class="form-label">Local</label>
                <select name="local_id" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($locals as $local)
                        <option value="{{ $local->id }}">{{ $local->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Despesa</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Data</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantidade</label>
                        <input type="number" step="0.001" name="quantity" class="form-control" placeholder="Ex: 25">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="unit_of_measure" class="form-label">Unidade de Medida</label>
                        <select name="unit_of_measure" class="form-select">
                            <option value="">Selecione a unidade</option>
                            <option value="kg">Quilograma (kg)</option>
                            <option value="g">Grama (g)</option>
                            <option value="t">Tonelada (t)</option>
                            <option value="l">Litro (l)</option>
                            <option value="ml">Mililitro (ml)</option>
                            <option value="m">Metro (m)</option>
                            <option value="cm">Centímetro (cm)</option>
                            <option value="m²">Metro quadrado (m²)</option>
                            <option value="m³">Metro cúbico (m³)</option>
                            <option value="unidade">Unidade</option>
                            <option value="pacote">Pacote</option>
                            <option value="saco">Saco</option>
                            <option value="caixa">Caixa</option>
                            <option value="hora">Hora</option>
                            <option value="dia">Dia</option>
                            <option value="mês">Mês</option>
                            <option value="serviço">Serviço</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('operational-expenses.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
